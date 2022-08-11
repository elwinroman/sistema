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

    // Controla el button editar del historial de cambios del cargo
    editChangesButton() {
        if(!this.loaded) return;

        let btnEditList = document.querySelectorAll('#datatable-historial-cambio td.actions button.editBtn');
        
        // eventos del button editar de la lista de historial
        for (const btnEdit of btnEditList) {
            btnEdit.addEventListener('click', () => {
                let row = btnEdit.closest('tr');
                
                // obtiene datos de la fila
                let cargo = {
                    'id'             : row.dataset.id,
                    'nombre'         : row.cells.namedItem('nombre').innerHTML,
                    'nro_plaza'      : row.cells.namedItem('nro_plaza').innerHTML,
                    'codigo'         : row.cells.namedItem('codigo').innerHTML,
                    'clasificacion'  : row.cells.namedItem('clasificacion').innerHTML,
                    'ordenanza'      : row.cells.namedItem('ordenanza').innerHTML,
                    'fecha_ordenanza': row.cells.namedItem('fecha_ordenanza').innerHTML,
                    'oficina_id'     : row.cells.namedItem('oficina_id').dataset.oficinaId,
                    'oficina_jefe'   : row.dataset.oficinaJefe      // opcional
                }

                // establece los datos obtenidos en el formulario de edición
                // establece el action_url del formulario
                let form_cargo = document.querySelector('#mostrar-cargo #editar-cargo-modal #form-cargo');
                let url_action = form_cargo.action;     // url del controlador de edición de cambios
                form_cargo.action = url_action + cargo.id;

                // establece los inputs
                form_cargo.querySelector('input[name="nombre"]').value = cargo.nombre;
                form_cargo.querySelector('input[name="nro-plaza"]').value = cargo.nro_plaza;
                form_cargo.querySelector('input[name="clasificacion"]').value = cargo.clasificacion;
                form_cargo.querySelector('input[name="codigo"]').value = cargo.codigo;
                form_cargo.querySelector('input[name="ordenanza"]').value = cargo.ordenanza;
                form_cargo.querySelector('input[name="fecha-ordenanza"]').value = this.toInternationalDateFormat(cargo.fecha_ordenanza);
                
                let oficinaJefeSelector = form_cargo.querySelector('select[name="oficina-jefe"]');
                let suboficinaSelector = form_cargo.querySelector('select[name="suboficina"]');
                let checkbox = form_cargo.querySelector('input[name="checkbox"]');

                // establece el chexbox y selects
                if(cargo.oficina_jefe !== '') {     // cuando oficina_id es suboficina
                    checkbox.checked = true;
                    suboficinaSelector.setAttribute('required', '');
                    suboficinaSelector.disabled = false;

                    // establece el selector oficina_jefe
                    for (let option of oficinaJefeSelector.options)
                        if(option.value === cargo.oficina_jefe) option.selected = true;

                    // obtiene lista de suboficinas
                    let data = { request: true, id: cargo.oficina_jefe };
                    let url = CONFIG.url_base + 'request/getsuboficinas';
            
                    fetch(url, { 
                        method : 'POST', 
                        body   : JSON.stringify(data)
                    }).then(response => response.json()).then(data => {
                        for(let i=0; i<data.length; i++) {

                            let option = document.createElement('option');
                            option.text = data[i].nombre;
                            option.value = data[i].id;

                            // establece el selector suboficina
                            if(data[i].id == cargo.oficina_id) option.selected = true;

                            suboficinaSelector.add(option);
                        }
                    }).catch(error => console.log(error.message));

                } else {        // cuando oficina_id es oficina-jefe
                    checkbox.checked = false;
                    suboficinaSelector.removeAttribute('required');
                    suboficinaSelector.disabled = true;
                    suboficinaSelector.length = 0;  // remove options
                    this.addPlaceholder(suboficinaSelector, 'no data');

                    // establece el selector oficina_jefe
                    for (let option of oficinaJefeSelector.options)
                        if(option.value === cargo.oficina_id) option.selected = true;
                }
            });
        }
    }

    // Elimina un cambio del historial de cambios de un cargo
    deleteChangesButton() {
        if(!this.loaded) return;

        let btnDeleteList = document.querySelectorAll('#datatable-historial-cambio td.actions button.deleteBtn');
        let table = document.querySelector('#datatable-historial-cambio');
        
        // eventos del button eliminar de la lista de historial
        for(let btnDelete of btnDeleteList) {
            btnDelete.addEventListener('click', function() {
                let row = btnDelete.closest('tr');
                let id = row.dataset.id;

                // no se puede eliminar todos los cambios, siempre debe quedar 1 mínimo
                if(table.tBodies[0].rows.length > 1) {

                    // elimina un cambio del historial
                    let data = { request: true, id: id };
                    let url = CONFIG.url_base + 'cargo/deleteChanges&id='+id;
                    
                    fetch(url, {
                        method : 'POST', 
                        body   : JSON.stringify(data)
                    }).then(response => response.json()).then(data => {
                        if(data.error) {
                            alert(data.mensaje);
                        } else {
                            alert(data);
                            table.deleteRow(row.rowIndex);
                        }
                    }).catch(error => console.log(error.message));

                } else {
                    alert('No se puede eliminar');
                }
            });
        }
    }   

    /**
     * Convierte la fecha local a fecha internacional ISO (YYYY-mm-dd)
     * @param  {String} fecha
     * @return {String}
     */
    toInternationalDateFormat(date) {
        return date.split('-').reverse().join('-');
    }

    addPlaceholder(select, msg) {
        let option = document.createElement('option');
        option.text = msg;
        option.selected = true;
        option.value = '';      // value vacio fuerza a que el required del select funcione apropiadamente
        option.setAttribute('hidden', 'hidden');
        select.add(option);
    }
}