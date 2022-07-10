import SelectHandler from "./modules/select.js";
import ListarOficina from "./modules/listar-oficina.js";

// Carga los diferentes módulos del objeto layout
export default class App {
    constructor() {
        this.selecthandler = new SelectHandler();
        this.listar_oficina = new ListarOficina();
    }

    load() {
        // Carga datos mediante ajax en el select oficina-jefe
        this.selecthandler.selectLoadData();

        // Habilita o desahabilita el select segpun el input-radio
        this.selecthandler.enableDisableSelect();

        // Despliega el dataTable con la lista de oficinas
        this.listar_oficina.datatableOficina();
    }
}