import utils from "./../../util/utils.js";

export default class Sidebar {
    constructor() {
        this.list_menu_link = document.querySelectorAll(".menu-link");
        this.toggle_sidebar = document.querySelector(".mynavbar .toggle-sidebar");
    }

    // Reposiciona los contenedores de submenús en paralelo a su menú padre (small sidebar)
    reposicionarContenedorSubmenus() {
        for(let menu_link of this.list_menu_link) {
            let submenu_container = menu_link.nextElementSibling;
            
            let pos = utils.getOffset(menu_link);
            submenu_container.style.top = pos.top + "px";
        }    
    }
    
    // Colapsa los contenedores de submenús
    colapsarSubmenusActivos() {
        let list_submenuContainer_active = document.querySelectorAll(".menu-panel.active .submenu-panel");
        
        list_submenuContainer_active.forEach(submenuContainer => {
            utils.animation.collapse(submenuContainer);
        });
    }
    
    // Remueve la clase 'active' de los menús activados * !!!!!!! refactorizar 
    removerClasesActivas() {
        let list_menuPanel_active = document.querySelectorAll(".menu-panel.active");
        
        list_menuPanel_active.forEach(menuPanel => {
            menuPanel.classList.remove("active");
        });
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
                        utils.animation.collapse(submenu_container);    // colapsa el menu activado
                        sessionStorage.removeItem("menu-link");         // elimina la session del menu activado
                    } else {
                        this.colapsarSubmenusActivos();
                        this.removerClasesActivas();
                        utils.animation.expand(submenu_container);      // expande el menu clickeado

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
            this.colapsarSubmenusActivos();
            this.removerClasesActivas();
            
            if(!document.body.classList.contains("short")) {    // si el sidebar es predeterminado
                let id_menuLink = sessionStorage.getItem("menu-link");
                
                // restaura el contenedor de submenú activo si existe en la session
                if(id_menuLink != null) {    
                    let submenu_container = document.querySelector(`.menu-link[data-id="${id_menuLink}"]`).nextElementSibling;
                    let menu_panel = document.querySelector(`.menu-link[data-id="${id_menuLink}"]`).parentElement;
                    menu_panel.classList.add("active");
                    utils.animation.expand(submenu_container);
                }
                
                sessionStorage.setItem("sidebar", "default");

            } else    // si el sidebar es pequeño
                sessionStorage.setItem("sidebar", "short");

        });
    }
}