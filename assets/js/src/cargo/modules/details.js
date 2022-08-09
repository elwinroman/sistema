import {DataTable as SimpleDataTable} from '../../../../../libs/simple-datatable-3.2.0/js/simple-datatable.js';
import CONFIG from './../../../config.js';

export default class DetailsPage {
    constructor() {
        this.loaded = document.querySelector('#mostrar-cargo');

        this.dataTable = null;
    }

    // Muestra o oculta el historial de cambios del cargo
    toggleHistorialCambio() {
        if(!this.loaded) return;

        let button_collapse = document.querySelector('#mostrar-cargo .btn-collapse');

        button_collapse.addEventListener('click', () => {
            let target = document.querySelector('.container-historial-cambio');
            let icon = document.querySelector('.btn-collapse > i');
            
            if(target.classList.contains('active')) {
                target.classList.remove('active');
                icon.classList.add('zmdi-plus-circle');
                icon.classList.remove('zmdi-minus-circle');
            } else {
                target.classList.add('active');
                icon.classList.remove('zmdi-plus-circle');
                icon.classList.add('zmdi-minus-circle');
            }
        });
    }

    datatableHistorialCambios() {
        if(!this.loaded) return;

        let table = document.querySelector('#datatable-historial-cambio');
   
        this.dataTable = new SimpleDataTable(table, {
            searchable    : false,
            sortable      : false,
            truncatePager : false,
            paging        : false,
            fixedHeight   : false,
            fixedColumns  : false
        });

        let widths = [
            { select: 0, width: '1%' },     // nro_plaza
            { select: 2, width: '1%' },     // codigo
            { select: 3, width: '1%' },     // clasificacion
            { select: 6, width: '110px' },  // fecha_ordenanza
            { select: 7, width: '1%' }      // actions
        ];

        // establece el tamaño de las columnas
        let head = this.dataTable.head;
        widths.forEach(width => {
            let th = head.querySelector('tr > th:nth-child(' + (width.select+1) +')');
            th.style.width = width.width;
        });
    }

    // Muestra u oculta un formulario para añadir cambios en el historial de cargo
    toggleFormAdd() {
        if(!this.loaded) return;

        let button_add = document.querySelector('#mostrar-cargo button.add');
        
        button_add.addEventListener('click', () => {
            let target = document.querySelector('#mostrar-cargo .form-add');
            target.classList.toggle('active');
        });
    }
