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
        let dataTableTop = this.wrapper.querySelector(".dataTable-top");
        let searchInput = dataTableTop.querySelector(".dataTable-search input.dataTable-input");
        let selectDropdown = dataTableTop.querySelector(".dataTable-dropdown select.dataTable-selector");
        
        searchInput.classList.add('input-ow');

        selectDropdown.classList.add('input-ow');
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
        let checkboxHandler = document.querySelectorAll('.column-visibility ul > li > input');
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
        let menu = document.querySelector('.column-visibility ul.column-visibility-menu');
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
}