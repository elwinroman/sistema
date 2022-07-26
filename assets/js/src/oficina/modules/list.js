import DataTable from '../../util/datatable.js';
import CONFIG from "./../../../config.js";

export default class ListPage {
    constructor() {
        this.loaded = document.querySelector("#lista-oficina");

        this.table = document.querySelector("#lista-oficina table#datatable-oficina");
        this.dt = undefined;
    }

    datatableOficina() {        
        if(!this.loaded)  return;

        // propiedades del dataTable
        let columns = [
            { select: 2, render: function(data, cell, row) {
                            if(data) return `<span class="wrapper-chief">${data}</span>`;
                            else return '';
                        }
            },
            {
                select: 3, render: function(id, cell, row) {
                            cell.classList.add("link-column");
                            row.firstChild.classList.add("num-column");
                            return `<i class="zmdi zmdi-plus-circle" data-id="${id}"></i>`; 
                        }
            },
            { select: 3, sortable: false }
        ];
        
        let widths = [
            { select: 0, width: "1%" },
            { select: 1, width: "50%" },
            { select: 3, width: "1%" }
        ];

        let classes = [
            { select: 0, class: "num-column" },
            { select: 3, class: "link-column"}
        ];
        
        // obtiene los datos mediante petición HTTP
        let url = CONFIG.url_base + "request/getoficinas";
        let data = { request: true };

        fetch(url, { method: "POST", body: JSON.stringify(data)
        }).then(response => response.json()).then(data => {  
            if(data.error) {
                this.table.innerHTML = 'Datos no disponibles';
                return;
            }

            var myData = {
                "headings" : Object.keys(data[0]),
                "data"     : data.map(row => Object.values(row))
            };

            this.dt = new DataTable(this.table, myData, columns);

            this.dt.setWidth(widths);   // establece el tamaño de las columnas
            this.dt.addClassToHead(classes);
            this.dt.hrefLinkColumns(CONFIG.url_base + 'oficina/details');

            this.dt.visibilityHandler();   // visibilidad de columnas
            
            this.exportToPDF();    // exporta PDF
            this.exportToExcel();  // exporta a Excel

        }).catch(error => console.log(error.message));
    }

    exportToPDF() {
        // estilos de la columna (jspdf-autotable)
        const config = {
            columnStyles: {         // tamaño de la página - 210 unidades contando margenes
                nro     : { halign: 'center', cellWidth: 10 },
                oficina : { cellWidth: 90 },
                organo  : { cellWidth: 80 }    
            },
            margin: { left: 15, right: 15 }
        };
        
        let pdfButton = document.querySelector('.pdf-button');
        pdfButton.addEventListener('click', () => this.dt.generatePDF(config));
    }

    exportToExcel() {
        let excelButton = document.querySelector('.excel-button');
        excelButton.addEventListener('click', () => this.dt.generateExcel());
    }
}