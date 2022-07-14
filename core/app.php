<?php

// Controlador frontal
class App {
    function __construct() {
        // comprueba si en la URL existe un controlador y una acción (controller/action)
        if(isset($_GET['controller']) && isset($_GET['action'])) {
            $nombre_controlador = $_GET['controller'].'Controller';

            // comprueba si el controlador y el método existen
            if(class_exists($nombre_controlador) && method_exists($nombre_controlador, $_GET['action'])) {
                $controlador = new $nombre_controlador;
                $action = $_GET['action'];                     
                $controlador->$action();
            } else {
                $error = new ErrorController();
            }
        } else {
            if(empty($_SESSION['username'])) {       // si no hay una session muestra la página de login
                $login = New LoginController();
                $login->view->render_login();
            } else {    // index por defecto
                $nombre_controlador = CONTROLLER_DEFAULT.'Controller';  // default controller
                $action = ACTION_DEFAULT;
                
                $controlador = new $nombre_controlador();
                $controlador->$action();  // default action
            }
        }
    }
}
?>