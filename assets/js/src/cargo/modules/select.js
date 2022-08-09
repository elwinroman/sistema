import CONFIG from './../../../config.js';

export default class Select {
    constructor() {
        this.loadedNew = document.querySelector('#crear-cargo');
        this.loadedDetails = document.querySelector('#mostrar-cargo');

        /** 
         * en la página de crear cargo, selectorAll contiene 1 item
         * en la página de mostrar cargo, selectorAll contiene 2 items
         *                                          [0] => añadir info del cargo en el historial de cambio
         *                                          [1] => editar info del cargo en el historial de cambio
         */
        this.oficinaJefeListSelector = document.querySelectorAll('#form-cargo select[name="oficina-jefe"]');
        this.suboficinaListSelector = document.querySelectorAll('#form-cargo select[name="suboficina"]');
        this.checkboxList = document.querySelectorAll('#form-cargo input[name="checkbox"]');
        
        this.size = this.suboficinaListSelector.length;
    }

    // Enable/disable suboficinas
    enableDisableSelectSuboficina() {
        if(!this.loadedNew && !this.loadedDetails) return;
        
        for(let i=0; i<this.size; i++) {
            // inicialización del select
            this.addPlaceholder(this.suboficinaListSelector[i], 'No data');
            
            if(this.checkboxList[i].checked)  {
                this.suboficinaListSelector[i].setAttribute('required', '');
                this.suboficinaListSelector[i].disabled = false;
            }
            else {
                this.suboficinaListSelector[i].removeAttribute('required');
                this.suboficinaListSelector[i].disabled = true;
            }

            // evento change en el checkbox
            this.checkboxList[i].addEventListener('change', () => {
                if(this.checkboxList[i].checked) {
                    this.suboficinaListSelector[i].setAttribute('required', '');
                    this.suboficinaListSelector[i].disabled = false;
                }
                else {
                    this.suboficinaListSelector[i].removeAttribute('required');
                    this.suboficinaListSelector[i].disabled = true;
                }
            });
        }
    }

    // Carga la lista de oficinas-jefe en el select órgano
    loadOficinasJefe() {
        if(!this.loadedNew && !this.loadedDetails) return;
        
        for(let i=0; i<this.size; i++) {

            let data = { request: true };
            let url = CONFIG.url_base + 'request/getoficinasjefe';
            
            fetch(url, {
                method  : 'POST',
                body    : JSON.stringify(data)
            }).then(response => response.json()).then(data => {
                // error
                if(data.error) {
                    this.addPlaceholder(this.suboficinaListSelector[i], data.mensaje);
                    return;

                } else {
                    this.addPlaceholder(this.oficinaJefeListSelector[i], 'Selecciona una opción');
                    this.addOptionToSelect(data, this.oficinaJefeListSelector[i]);
                }

            }).catch(error => console.log(error.message));
        }
    }

    // Carga la lista de suboficinas de una oficina-jefe en el select unidad orgánica,
    loadSuboficinas() {
        if(!this.loadedNew && !this.loadedDetails) return;

        let self = this;
        
        for(let i=0; i<this.size; i++) {

            self.oficinaJefeListSelector[i].addEventListener('change', function() {
                let id_oficinaJefe = this.value;
                
                let data = { request: true, id: id_oficinaJefe };
                let url = CONFIG.url_base + 'request/getsuboficinas';
        
                fetch(url, {
                    method  : 'POST',
                    body    : JSON.stringify(data)
                }).then(response => response.json()).then(data => {
                    
                    self.removeOptions(self.suboficinaListSelector[i]);
                    
                    // error
                    if(data.error) {
                        self.addPlaceholder(self.suboficinaListSelector[i], data.mensaje);
                        return;
        
                    } else { 
                        self.addPlaceholder(self.suboficinaListSelector[i], 'Selecciona una opción');
                        self.addOptionToSelect(data, self.suboficinaListSelector[i]);
                    }
        
                }).catch(error => console.log(error.message));
            });
        }
    }

    /**
     * Crea el objeto <option> y lo añade al <select>
     * @param {Array}       data   Lista de oficinas jefes
     * @param {HTMLElement} select
     */ 
     addOptionToSelect(data, select) {
        for(let i=0; i<data.length; i++) {

            let option = document.createElement('option');
            option.text = data[i].nombre;
            option.value = data[i].id;

            select.add(option);
        }
    }

    /**
     * Añade placeholder del select cuando no está seleccionado ninguna opción
     * @param {HTMLElement} select 
     * @param {String}      msg
     */
    addPlaceholder(select, msg) {
        let option = document.createElement('option');
        option.text = msg;
        option.selected = true;
        option.value = '';      // value vacio fuerza a que el required del select funcione apropiadamente
        option.setAttribute('hidden', 'hidden');
        select.add(option);
    }

    // Remueve todos las <options> de un <select>
    removeOptions(select) {
        select.length = 0;
    }
}