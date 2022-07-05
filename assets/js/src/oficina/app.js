import Oficina from "./modules/oficina.js";

// Carga los diferentes módulos del objeto layout
export default class App {
    constructor() {
        this.oficina = new Oficina();
    }

    load() {
        // Carga datos mediante ajax en el select oficina-jefe
        this.oficina.selectLoadData();

        // Habilita o desahabilita el select segpun el input-radio
        this.oficina.enableDisableSelect();
    }
}