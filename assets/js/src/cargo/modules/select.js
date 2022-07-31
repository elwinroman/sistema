import CONFIG from './../../../config.js';

export default class Select {
    constructor() {
        this.loadedNew = document.querySelector('#crear-cargo');

        this.oficinaJefe_select = document.querySelector('#form-cargo select[name="oficina-jefe"]');
        this.suboficina_select = document.querySelector('#form-cargo select[name="suboficina"]');
    }

    // Enable/disable suboficinas
    enableDisableSelectSuboficina() {
        if(!this.loadedNew) return;

        // inicialización del select
        let checkbox = document.querySelector('#form-cargo input[name="checkbox"]');
        this.addPlaceholder(this.suboficina_select, 'No data');

        if(checkbox.checked)  {
            this.suboficina_select.setAttribute('required', '');
            this.suboficina_select.disabled = false;
        }
        else {
            this.suboficina_select.removeAttribute('required');
            this.suboficina_select.disabled = true;
        }

        // evento change en el checkbox
        checkbox.addEventListener('change', () => {
            if(checkbox.checked) {
                this.suboficina_select.setAttribute('required', '');
                this.suboficina_select.disabled = false;
            }
            else {
                this.suboficina_select.removeAttribute('required');
                this.suboficina_select.disabled = true;
            }
        });
    }

    // Carga la lista de oficinas-jefe en el select órgano
    loadOficinasJefe() {
        if(!this.loadedNew) return;

        let data = { request: true };
        let url = CONFIG.url_base + 'request/getoficinasjefe';

        fetch(url, {
            method  : 'POST',
            body    : JSON.stringify(data)
        }).then(response => response.json()).then(data => {
            // error
            if(data.error) {
                self.addPlaceholder(self.suboficina_select, data.mensaje);
                return;

            } else {
                this.addPlaceholder(this.oficinaJefe_select, 'Selecciona una opción');
                this.addOptionToSelect(data, this.oficinaJefe_select);
            }

        }).catch(error => console.log(error.message));
    }

    // Carga la lista de suboficinas de una oficina-jefe en el select unidad orgánica,
    loadSuboficinas() {
        if(!this.loadedNew) return;

        let self = this;
        
        self.oficinaJefe_select.addEventListener('change', function() {
            let id_oficinaJefe = this.value;
            
            let data = { request: true, id: id_oficinaJefe };
            let url = CONFIG.url_base + 'request/getsuboficinas';
    
            fetch(url, {
                method  : 'POST',
                body    : JSON.stringify(data)
            }).then(response => response.json()).then(data => {
                
                self.removeOptions(self.suboficina_select);
                
                // error
                if(data.error) {
                    self.addPlaceholder(self.suboficina_select, data.mensaje);
                    return;
    
                } else { 
                    self.addPlaceholder(self.suboficina_select, 'Selecciona una opción');
                    self.addOptionToSelect(data, self.suboficina_select);
                }
    
            }).catch(error => console.log(error.message));

        });
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