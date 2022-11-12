import utils from "./../../util/utils.js";

export default class Sidebar {
    constructor() {
        this.list_menu_link = document.querySelectorAll(".menu-link");
        this.toggle_sidebar = document.querySelector(".mynavbar .toggle-sidebar");

        // inicializacion
        this.root = document.querySelector(':root');
        this.rs = window.getComputedStyle(this.root);
        this.duration = this.rs.getPropertyValue('--myduration');
        this.root.style.setProperty('--myduration', '0ms');
        sessionStorage.setItem('sidebar', 'default');   // inicialización predeterminada

        if(sessionStorage.getItem('sidebar') === 'short') {
            document.body.classList.add('short');

        } else if(sessionStorage.getItem('sidebar') === 'default') {

            switch(true) {
                case window.innerWidth <= 575:
                    document.body.classList.add('short');
                    break;
                default:
                    // restaura el contenedor del submenu activado
                    this.restoreSubmenuContainer();
            }
        }
    }

    // Toggle que muestra y oculta los contenedores de submenús
    toggleSubmenuContainer() {
        for(let menu_link of this.list_menu_link) {
            
            // 'arrow function' evita el alcance de 'this' del disparador de eventos  
            menu_link.addEventListener("click", () => {
                let menu_panel = menu_link.parentElement;
                let submenu_container = menu_link.nextElementSibling;
                
                // si el sidebar es predeterminado
                if(!document.body.classList.contains('short')) {
                    // condicional para el toggle mismo
                    if(menu_panel.classList.contains("active")) {
                        utils.animation.collapse(submenu_container, 200);    // colapsa el menu activado
                        sessionStorage.removeItem("menu-link");              // elimina la session del menu activado
                    } else {
                        this.colapsarSubmenusActivos();
                        this.removerClasesActivas();
                        utils.animation.expand(submenu_container, 200);      // expande el menu clickeado

                        // guardar la session del menú activado
                        let val = menu_link.dataset.id;
                        sessionStorage.setItem("menu-link", val);
                    }
                } else {    // si el sidebar es pequeño
                    this.reposicionarContenedorSubmenus();
                    
                    if (!menu_panel.classList.contains("active")) this.removerClasesActivas();
                }

                menu_panel.classList.toggle("active");
            });
        }
    }

    // Toggle que muestra el sidebar predeterminado o sidebar pequeño al hacer click en el icono burguer
    toggle() {
        this.toggle_sidebar.addEventListener("click", () => {
            document.body.classList.toggle("short");
            
            this.root.style.setProperty('--myduration', this.duration);
            
            if(!document.body.classList.contains('short')) {    // para ver sidebar predeterminado
                this.removerClasesActivas();
                sessionStorage.setItem('sidebar', 'default');
                this.restoreSubmenuContainer();

            } else {    // para ver sidebar pequeño
                this.colapsarSubmenusActivos();
                sessionStorage.setItem('sidebar', 'short');
            }

        });
    }

    // Colapsa el contenedor del submenú activado (solo del short sidebar) clickeando en cualquier lugar de la página o redimensionando
    collapseSubmenuContainer() {
        document.body.addEventListener('click', () => {
            if(document.body.classList.contains('short')) this.removerClasesActivas();
        });

        // excluye los disparadores que abren el contenedor
        for(let menu_link of this.list_menu_link) {
            menu_link.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        window.addEventListener('resize', () => {
            if(document.body.classList.contains('short')) this.removerClasesActivas();
        });
    }

    // Comportamiento del sidebar al redimensionar la ventana
    resizeEvent() {
        window.addEventListener('resize', () => {

            if(sessionStorage.getItem('sidebar') === 'default') {
                switch(true) {
                    case window.innerWidth <= 575:
                        this.removerClasesActivas();
                        document.body.classList.add('short');
                        break;
                    default:
                        document.body.classList.remove('short');
                        this.restoreSubmenuContainer();
                }
            }
            
        });
    }

    // Restaura el contenedor del submenú expandido después de actualizar la página
    restoreSubmenuContainer() {
        let id_menuLink = sessionStorage.getItem('menu-link');

        if(id_menuLink) {    
            let submenu_container = document.querySelector(`.menu-link[data-id="${id_menuLink}"]`).nextElementSibling;
            let menu_panel = document.querySelector(`.menu-link[data-id="${id_menuLink}"]`).parentElement;
            menu_panel.classList.add('active');
            utils.animation.expand(submenu_container, 200);
        }
    }

    // Reposiciona los contenedores de submenús en paralelo a su menú padre (small sidebar)
    reposicionarContenedorSubmenus() {
        for(let menu_link of this.list_menu_link) {
            let submenu_container = menu_link.nextElementSibling;
            
            let pos = utils.getOffset(menu_link);
            submenu_container.style.top = pos.top + 'px';
        }    
    }
    
    // Colapsa los contenedores de submenús
    colapsarSubmenusActivos() {
        let list_submenuContainer_active = document.querySelectorAll('.menu-panel.active .submenu-panel');
        
        list_submenuContainer_active.forEach(submenuContainer => {
            utils.animation.collapse(submenuContainer, 200);
        });
    }
    
   // Remueve la clase 'active' de los menús activados
    removerClasesActivas() {
        let list_menuPanel_active = document.querySelectorAll('.menu-panel.active');
        
        list_menuPanel_active.forEach(menuPanel => {
            menuPanel.classList.remove('active');
        });
    }
}