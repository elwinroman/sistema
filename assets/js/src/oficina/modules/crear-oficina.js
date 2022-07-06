export default class CrearOficina {
    
    constructor() {
        this.select_oficina = document.querySelector('#form-oficina select[name="oficina-jefe"]');
        this.radioinput = {
            oficinajefe: document.querySelector('#form-oficina input#oficinajefe[type="radio"]'),
            suboficina: document.querySelector('#form-oficina input#suboficina[type="radio"]')
        }
    }

    // Habilita o deshabilita el select según el input-radio seleccionado
    enableDisableSelect() {
        // Estado inicial del radio input
        if(this.radioinput.oficinajefe.checked)
            this.select_oficina.disabled = true;
        if(this.radioinput.suboficina.checked)
            this.select_oficina.disabled = false;
        
        // Deshabilita el select (cuando se crea una oficina jefe)
        this.radioinput.oficinajefe.addEventListener("change", () => {
            if(this.radioinput.oficinajefe.checked)
                this.select_oficina.disabled = true;
        });
        // Habilita el select (cuando se crea una suboficina)
        this.radioinput.suboficina.addEventListener("change", () => {
            if(this.radioinput.suboficina.checked)
                this.select_oficina.disabled = false;
        });
    }

    // Carga en el select oficina-jefe una lista de las oficinas jefe
    selectLoadData() {
        let data = { request: true };
        let url = "http://localhost/github/sistema/request/getOficinasJefe";
        fetch(url, {
            method  : 'POST',
            body    : JSON.stringify(data),
            headers : {
                'Accept'       : 'aplication/json',
                'Content-Type' : 'aplication/json'
            }
        }).then(response => response.json()).then(data => {
            // Si no existen datos
            if(data.error) {
                let option = document.createElement("option");
                option.text = data.mensaje;
                this.select_oficina.add(option);
            } else {
                for(let i=0; i<data.length; i++) {
                    let option = document.createElement("option");
                    option.text = data[i].nombre;
                    option.value = data[i].id;
                    this.select_oficina.add(option);
                }
            }
        }).catch(error => console.log(error.message));
    }
}
