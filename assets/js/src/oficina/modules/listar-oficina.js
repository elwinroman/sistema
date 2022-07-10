import DataTable from './../../util/datatable.util.js';
export default class ListarOficina {

    constructor() {
        this.loaded = document.querySelector("#lista-oficina");

        this.table = document.querySelector("#lista-oficina table#datatable-oficina");
        this.dt = undefined;
    }

    datatableOficina() {
        
        if(!this.loaded)  return;

        // propiedades del dataTable
        let columns = [
            { 
                select: 2, 
                render: function(id, cell, row) {
                            cell.classList.add("link-column");
                            row.firstChild.classList.add("num-column");
                            return `<i class="zmdi zmdi-plus-circle" data-id="${id}"></i>`; 
                        }
            },
            { select: 2, sortable: false }
        ];
        
        let widths = [
            { select: 0, width: "1%" },
            { select: 2, width: "1%" }
        ];

        let classes = [
            { select: 0, class: "num-column" },
            { select: 2, class: "link-column"}
        ];
        
        // obtiene los datos mediante petición HTTP
        let url = "http://localhost/github/sistema/request/getListaOficinas";
        let data = { request: true };

        fetch(url, { method: "POST", body: JSON.stringify(data)
        }).then(response => response.json()).then(data => {  
            var myData = {
                "headings" : Object.keys(data[0]),
                "data"     : data.map(row => Object.values(row))
            };

            this.dt = new DataTable(this.table, myData, columns);

            this.dt.setWidth(widths);   // establece el tamaño de las columnas
            this.dt.addClass(classes);
            this.dt.hrefLinkColumns("oficina/mostrar");

        }).catch(error => console.log(error.message));
    }
}