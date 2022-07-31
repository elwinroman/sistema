import Select from "./modules/select.js";
// import ListPage from "./modules/list.js";

// Carga funcionalidades del módulo cargo
export default class App {
    constructor() {
        this.select = new Select();
        // this.listPage = new ListPage();
    }

    load() {
        // carga la lista de oficinas-jefe
        this.select.loadOficinasJefe();

        // carga la lista de suboficinas de una oficina-jefe
        this.select.loadSuboficinas();
        
        // habilita o desahabilita el select suboficinas según el checkbox
        this.select.enableDisableSelectSuboficina();
    }
}