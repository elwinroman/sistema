import CONFIG from "./../../../config.js";

export default class Select {
    constructor() {
        this.loadedNew = document.querySelector("#crear-oficina");
        this.loadedEdit = document.querySelector("#editar-oficina-modal");

        this.select_oficina = document.querySelector('#form-oficina select[name="oficina-jefe"]');
        this.radioinput = {
            oficinajefe: document.querySelector('#form-oficina input#oficinajefe[type="radio"]'),
            suboficina: document.querySelector('#form-oficina input#suboficina[type="radio"]')
        }
    }

    // Habilita o deshabilita el select según el input-radio seleccionado
    enableDisableSelect() {
        if(!this.loadedNew && !this.loadedEdit) return;

        // estado inicial del radio input
        if(this.radioinput.oficinajefe.checked)
            this.select_oficina.disabled = true;
        if(this.radioinput.suboficina.checked)
            this.select_oficina.disabled = false;
        
        // deshabilita el select (cuando se crea una oficina jefe)
        this.radioinput.oficinajefe.addEventListener("change", () => {
            if(this.radioinput.oficinajefe.checked)
                this.select_oficina.disabled = true;
        });
        // habilita el select (cuando se crea una suboficina)
        this.radioinput.suboficina.addEventListener("change", () => {
            if(this.radioinput.suboficina.checked)
                this.select_oficina.disabled = false;
        });
    }

    // Carga en el select oficina-jefe una lista de las oficinas jefe
    selectLoadData() {
        if(!this.loadedNew && !this.loadedEdit) return;
        
        let data = { request: true };
        let url = CONFIG.url_base + "request/getoficinasjefe";

        fetch(url, {
            method  : 'POST',
            body    : JSON.stringify(data)
        }).then(response => response.json()).then(data => {
            // Si no existen datos
            if(data.error) {
                let option = document.createElement("option");
                option.text = data.mensaje;
                this.select_oficina.add(option);
                return;
            } else {
                // placeholder select si es para crear oficina o editar oficina jefe
                if(!this.select_oficina.dataset.selected) this.addPlaceholder();
                this.addOptionToSelect(data);
            }

        }).catch(error => console.log(error.message));
    }

    /**
     * Crea el objeto <option> y añade al select
     * @param {Array} data Lista de oficinas jefes
     */ 
    addOptionToSelect(data) {
        for(let i=0; i<data.length; i++) {
            
            
            // si está en la edicion de oficina y es una oficina jefe no debe seleccionarse a sí mismo
            if(this.loadedEdit) {
                let id_oficina = document.querySelector('#oficina-name-id').dataset.id;
                
                if(id_oficina == data[i].id) continue;
            }

            let option = document.createElement('option');
            option.text = data[i].nombre;
            option.value = data[i].id;

            // si está en la edición de oficina, selecciona la oficina jefe correspondiente
            if(this.loadedEdit && this.select_oficina.dataset.selected == data[i].id) 
                option.selected = true;

            this.select_oficina.add(option);
        }
    }

    addPlaceholder() {
        let option = document.createElement('option');
        option.text = 'Seleccione una opción';
        option.selected = true;
        option.setAttribute('hidden', 'hidden');
        this.select_oficina.add(option);
    }
}