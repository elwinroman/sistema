import Select from './modules/select.js';
import ListPage from './modules/list.js';
import DetailsPage from './modules/details.js';

// Carga funcionalidades del módulo cargo
export default class App {
    constructor() {
        this.select = new Select();
        this.listPage = new ListPage();
        this.detailsPage = new DetailsPage();
    }

    load() {
        // carga la lista de oficinas-jefe
        this.select.loadOficinasJefe();

        // carga la lista de suboficinas de una oficina-jefe
        this.select.loadSuboficinas();
        
        // habilita o desahabilita el select suboficinas según el checkbox
        this.select.enableDisableSelectSuboficina();
        
        // despliega el dataTable con la lista de cargos, busqueda y opciones de exportación
        this.listPage.datatableCargo();

        // toggle que muestra el historial de cambios de un cargo
        this.detailsPage.toggleHistorialCambio();

        // datatable del historial de cambios
        this.detailsPage.datatableHistorialCambios();

        // toggle formulario que añade cambios en el historial de cargo
        this.detailsPage.toggleFormAdd();

        // controla el button editar del historial de cambios del cargo
        this.detailsPage.editChangesButton();

        // elimina un cambio del historial de cambios de un cargo
        this.detailsPage.deleteChangesButton();
    }
}