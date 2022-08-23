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

        // colapsa el contenedor del submenú activado (solo del short sidebar) clickeando en cualquier lugar de la página
        this.sidebar.collapseSubmenuContainer();

        // comportamiento del sidebar al redimensionar la ventana
        this.sidebar.resizeEvent();
    }
}