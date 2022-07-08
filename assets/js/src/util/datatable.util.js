export default class DataTable {

    constructor(table, data, columns) {
        this.table = table;     // HTMLElement
        this.data = data;
        this.columns = columns;

        this.dataTable = this.new();      
        this.thead = this.dataTable.head;    // HTMLElement
        this.wrapper = this.dataTable.wrapper;

        this.formatOwnStyles();
    }

    new() {
        return new simpleDatatables.DataTable(this.table, {
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
            data          : this.data,
            perPage : 5
        });
    }

    /**
     * Define el tamaño de las columnas (<thead>)
     * @param {Array} data select es la posición de la columna
     * @example [ { select: 0, width: "5%" },
     *            { select: 2, width: "50%" },
     *            ...
     *          ]
     */
    setWidth(data) {
        data.forEach(element => {
            // let th = this.head.querySelector("th:nth-child("+element.select+")");
            let th = this.thead.querySelector("tr > th:nth-child(" + (element.select+1) +")");
            th.style.width = element.width;
        });
    }
    /**
     * Añade clases a las columnas (<thead>)
     * @param {Array} data select es la posici+ón de la columna
     * @example [ { select: 0, class: "class1" },
     *            { select: 2, class: "class2" },
     *            ...
     *          ]
     */
    addClass(data) {
        data.forEach(element => {
            let th = this.thead.querySelector("tr > th:nth-child(" + (element.select+1) + ")");
            th.classList.add(element.class);
        });
    }

    // Formatea estilos de simple-dataTable añadiendo clases propias
    formatOwnStyles() {
        let dataTableTop = this.wrapper.querySelector(".dataTable-top");
        let dataTableBottom = this.wrapper.querySelector(".dataTable-bottom");
        let searchInput = dataTableTop.querySelector(".dataTable-search input.dataTable-input");
        let selectDropdown = dataTableTop.querySelector(".dataTable-dropdown select.dataTable-selector");

        searchInput.classList.add("input-ow");

        dataTableTop.style.fontSize = "0.85rem";
        dataTableBottom.style.fontSize = "0.85rem";

        selectDropdown.classList.add("input-ow");
        selectDropdown.style.width = "45px";
        selectDropdown.style.display = "inline-block";
        selectDropdown.style.paddingLeft = "2px";
        selectDropdown.style.paddingRight = "0";
    }
}