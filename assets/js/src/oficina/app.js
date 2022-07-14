import SelectHandler from "./modules/select.js";
import ListPage from "./modules/list.js";

// Carga los diferentes módulos del objeto layout
export default class App {
    constructor() {
        this.selecthandler = new SelectHandler();
        this.listPage = new ListPage();
    }

    load() {
        // carga datos mediante ajax en el select oficina-jefe
        this.selecthandler.selectLoadData();

        // habilita o desahabilita el select segpun el input-radio
        this.selecthandler.enableDisableSelect();

        // despliega el dataTable con la lista de oficinas
        this.listPage.datatableOficina();
    }
}