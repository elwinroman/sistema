import CrearOficina from "./modules/crear-oficina.js";
import ListarOficina from "./modules/listar-oficina.js";
import MostrarOficina from "./modules/mostrar-oficina.js";

// Carga los diferentes módulos del objeto layout
export default class App {
    constructor() {
        this.crear_oficina = new CrearOficina();
        this.listar_oficina = new ListarOficina();
        this.mostrarOficina = new MostrarOficina();
    }

    load() {
        // Carga datos mediante ajax en el select oficina-jefe
        this.crear_oficina.selectLoadData();

        // Habilita o desahabilita el select segpun el input-radio
        this.crear_oficina.enableDisableSelect();

        // Despliega el dataTable con la lista de oficinas
        this.listar_oficina.datatableOficina();
    }
}