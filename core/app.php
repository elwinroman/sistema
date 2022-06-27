<?php

// Controlador frontal
class App {

    function __construct() {
        // Comprueba si en la URL existe un controlador y una acción (controller/action)
        if(isset($_GET['controller']) && isset($_GET['action'])) {
            $nombre_controlador = $_GET['controller'].'Controller';

            // Comprueba si el controlador y el método existen
            if(class_exists($nombre_controlador) && method_exists($nombre_controlador, $_GET['action'])) {
                $controlador = new $nombre_controlador;
                $action = $_GET['action'];                     
                $controlador->$action();
            } else {
                $error = new ErrorController;
            }
        } else {    // Index por defecto
            $nombre_controlador = CONTROLLER_DEFAULT.'Controller';  // default controller
            $action = ACTION_DEFAULT;
            $controlador = new $nombre_controlador();
            $controlador->$action();  // default action
        }
    }
}
?>