import DataTable from '../../util/datatable.js';
import CONFIG from './../../../config.js';

export default class ListPage {
    constructor() {
        this.loaded = document.querySelector('#lista-cargo');

        this.table = document.querySelector('#lista-cargo table#datatable-cargo');
        this.dt = undefined;
    }

    datatableCargo() {
        if(!this.loaded) return;
        
        // propiedades del dataTable
        let columns = [
            { select: 0, render: (data, cell) => { 
                            cell.classList.add('num-column');
                            return data; 
                        } 
            },
            { select: 5, render: (id, cell) => {
                            cell.classList.add('link-column');
                            return `<i class="zmdi zmdi-plus-circle" data-id="${id}"></i>`; 
                        }
            },
            { select: 5, sortable: false }
        ];
        
        let widths = [
            { select: 0, width: '1%' },     // nro
            { select: 1, width: '30%' },    // nombre
            { select: 2, width: '15%' },    // clasificacion
            { select: 3, width: '15%' },    // codigo
            { select: 4, width: '30%' },    // oficina
            { select: 5, width: '1%' }      // ver
        ];

        let classes = [
            { select: 0, class: 'num-column' },     // nro
            { select: 5, class: 'link-column' }      // ver
        ];
        
        let url = CONFIG.url_base + 'request/getcargos';
        let data = { request: true };

        fetch(url, { method: 'POST', body: JSON.stringify(data)
        }).then(response => response.json()).then(data => {  

            if(data.error) {
                this.table.innerHTML = 'Datos no disponibles';
                return;
            }

            let myData = {
                'headings' : Object.keys(data[0]),
                'data'     : data.map(row => Object.values(row))
            };

            this.dt = new DataTable(this.table, myData, columns);
            this.dt.setWidth(widths);   // establece el tamaño de las columnas
            this.dt.addClassToHead(classes);

            this.dt.hrefLinkColumns(CONFIG.url_base + 'cargo/details');

            this.dt.visibilityHandler();   // visibilidad de columnas
            
            this.exportToPDF();    // exporta PDF
            this.exportToExcel();  // exporta a Excel

        }).catch(error => console.log(error.message));
    }

    exportToPDF() {
        // estilos de la columna (jspdf-autotable)
        const config = {
            columnStyles: {         // tamaño de la página - 210 unidades contando margenes
                'nro'     : { halign: 'center', cellWidth: 10 },
                'nombre'  : { cellWidth: 60 },
                'oficina' : { cellWidth: 60 }    
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