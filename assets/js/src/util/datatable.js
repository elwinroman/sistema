import {DataTable as SimpleDataTable} from "../../../../libs/simple-datatable-3.2.0/js/simple-datatable.js";

export default class DataTable {
    constructor(table, data, columns) {
        this.table = table;     // HTMLElement
        this.data = data;
        this.columns = columns;

        this.dataTable = this.new();      
        this.thead = this.dataTable.head;    // HTMLElement
        this.wrapper = this.dataTable.wrapper;

        // añade estilos propios al datatable
        this.formatOwnStyles();
    }

    new() {
        return new SimpleDataTable(this.table, {
            // Opciones predeterminadas
            labels        : {
                placeholder : "Buscar...",
                perPage     : "Mostrar {select} registros",
                noRows      : "No hay datos para mostrar",
                info        : "Mostrando registros del {start} al {end} de un total de {rows} registros"
            },
            perPageSelect : [10, 20, 40, 80],
            fixedHeight   : false,
            fixedColumns  : false,
            columns       : this.columns,
            data          : this.data
        });
    }

    /**
     * Define el tamaño de las columnas (<thead>)
     * @param {Array} data select es la posición de la columna
     * @example [ { select: 0, width: "5%" },
     *            { select: 2, width: "50%" },
     *            ... ]
     */
    setWidth(data) {
        data.forEach(element => {
            let th = this.thead.querySelector("tr > th:nth-child(" + (element.select+1) +")");
            th.style.width = element.width;
        });
    }
    /**
     * Añade clases a los encabezados de las columnas (<thead>)
     * @param {Array} data select es la posici+ón de la columna
     * @example [ { select: 0, class: "class1" },
     *            { select: 2, class: "class2" },
     *            ... ]
     */
    addClassToHead(data) {
        data.forEach(element => {
            let th = this.thead.querySelector("tr > th:nth-child(" + (element.select+1) + ")");
            th.classList.add(element.class);
        });
    }

    /**
     * Redirecciona para ver con más detalle al hacer click en (+)
     * @param {string} url
     */
     hrefLinkColumns(url) {
        let redirect = function() {
            let icon_list = this.wrapper.querySelectorAll(".datatable-ow td.link-column > i");
            
            icon_list.forEach(icon => {
                icon.addEventListener("click", function() {
                    let id = this.dataset.id;
                    location.href = url + "&id=" + id;     
                });
            });
        }

        // eventos de ejecución
        this.dataTable.on('datatable.search', redirect);
        this.dataTable.on('datatable.perpage', redirect);
        this.dataTable.on('datatable.init', redirect);
        this.dataTable.on('datatable.sort', redirect);
        this.dataTable.on('datatable.page', redirect);
        this.dataTable.on('datatable.update', redirect);
    }

    // Formatea estilos de simple-dataTable añadiendo clases propias
    formatOwnStyles() {
        let dataTableContainer = document.querySelector('.dataTable-container');
        let dataTableTop = this.wrapper.querySelector(".dataTable-top");
        let searchInput = dataTableTop.querySelector(".dataTable-search input.dataTable-input");
        let selectDropdown = dataTableTop.querySelector(".dataTable-dropdown select.dataTable-selector");
        
        dataTableTop.style.padding = '8px 0';
        searchInput.classList.add('input-ow','input-height-ow');

        selectDropdown.classList.add('input-ow','input-height-ow');
        selectDropdown.style.width = '45px';
        selectDropdown.style.display = 'inline-block';
        selectDropdown.style.paddingLeft = '2px';
        selectDropdown.style.paddingRight = '0';
    }

    // Handler para la visibilidad de columnas EXCEPTO la columna de (+)details
    visibilityHandler() {
        let columnasVisibles = this.dataTable.columns().visible();
        let headings = this.dataTable.headings;     // dataTable headings HTMLCollection

        for(let i=0; i<columnasVisibles.length-1; i++) {
            let nombre = headings[i].textContent;
            let value = i;
            this.newVisibilityColumnHandler(value, nombre, columnasVisibles[i]);
        }

        // evento checkbox que oculta o muestra columnas
        let checkboxHandler = document.querySelectorAll('.table-options-ow ul.visibility-menu > li > input');
        checkboxHandler.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                let column = parseInt(checkbox.value);
                
                if(checkbox.checked) this.dataTable.columns().show([column]);
                else  this.dataTable.columns().hide([column]);
            });
        });
    }

    /**
     * Crea un elemento HTML para la visibilidad de columnas => (<li><input type="checkbox"><label></li>)
     * @param {String} value          Nro de columna del datatable 
     * @param {String} nombre         Nombre de la columna
     * @param {Bool}   columnavisible Columna visible o no
     */
    newVisibilityColumnHandler(value, nombre, columnavisible) {
        let menu = document.querySelector('.table-options-ow ul.visibility-menu');
        let li = document.createElement('li');
        let input = document.createElement('input');
        let label = document.createElement('label');

        // atributos input
        input.setAttribute('type', 'checkbox');
        input.setAttribute('class', 'form-check-input');
        input.setAttribute('value', value);

        if(columnavisible) input.checked = true;

        label.innerHTML = nombre;

        // añadiendo
        li.appendChild(input);
        li.appendChild(label);
        menu.appendChild(li);
    }

    generateExcel() {
        // genera worksheet
        let exportableData = this.prepareDataToExport();
        let worksheet = XLSX.utils.json_to_sheet(exportableData.data, {origin: 'A2', skipHeader: true});
        
        // obtiene el tamaño maximo de cada columna
        const fitToColumn = data => {    
            let columnWidths = [];

            for(let property in data[0]) {      
                columnWidths.push({ wch: Math.max(property ? property.toString().length : 0, 
                        ...data.map(obj => obj[property] ? obj[property].toString().length : 0))});   
            }

            return columnWidths;
        };

        worksheet['!cols'] = fitToColumn(exportableData.data);
        
        // agrega los headers
        let headers = exportableData.columnas.map(col => col.header);
        XLSX.utils.sheet_add_aoa(worksheet, [headers]);

        // genera workbook
        let worbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(worbook, worksheet, 'lista');
        
        XLSX.writeFile(worbook, 'reporte.xlsx');
    }

    /** 
     * Genera un objeto URL en el browser de tipo PDF
     * @param {Object} config Objeto de configuración
    */
    generatePDF(config) {
        let exportableData = this.prepareDataToExport();

        // genera reporte
        let doc = new jspdf.jsPDF();
        
        doc.autoTable({
            columns: exportableData.columnas,
            body   : exportableData.data,
            theme  : 'striped',
            columnStyles: config.columnStyles,
            styles: {
                cellPadding: 2
            },
            margin: config.margin
        });

        window.open(doc.output('bloburl'));
    }

    /**
     * Prepara y organiza los datos para la exportación a pdf, excel o print
     * @return {Object} columnas[], data[] 
     */
     prepareDataToExport() {
        // head
        let columnas = [];
        for(let [index, head] of this.dataTable.headings.entries()) {
            
            // evita agregar la columna de link
            if(index == this.dataTable.headings.length-1) break;
            
            // selecciona solo las columnas visibles
            let visibleColumns = this.dataTable.columns().visible();
            if(visibleColumns[index] == true) {
                columnas.push({
                    header: head.textContent, 
                    dataKey: head.textContent.toLowerCase()
                });
            }
        }
        
        // body
        let data = [];
        for(let [index, tableRow] of this.dataTable.activeRows.entries()) {
            let row = {};
            let cont = 0;
            
            for(let cell of tableRow.cells) {
                row[columnas[cont].dataKey] = cell.textContent;
                cont++;

                // evita agregar la columna de link
                if(cont == tableRow.cells.length-1) break;
            }

            // cuando se realiza una búsqueda selecciona los datos coincidentes
            if(this.dataTable.searching) {
                let match_result = this.dataTable.searchData;  // array de indices de los resultados de búsqueda
                
                if(match_result.includes(index)) data.push(row);

            } else data.push(row);
        }

        return {columnas, data};
    }
}