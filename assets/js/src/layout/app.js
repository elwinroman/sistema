import Sidebar from "./modules/sidebar.js";

// Carga los diferentes módulos del objeto layout
export default class App {
    constructor() {
        this.sidebar = new Sidebar();
    }

    load() {
        // Expande y collapsa el contenedor de submenus
        this.sidebar.toggleSubmenuContainer();

        // Cambia el sidebar al modo pequeño o predeterminado (toggle)
        this.sidebar.toggle();
    }
}