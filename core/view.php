<?php
class View {

    public function __construct() {
    }

    /**
     * Función que renderizza o carga la vista
     * 
     * @param{String} $nombre   Nombre del archivo de la vista
     *                          incluyendo la carpeta
     */
    public function render($nombre) {
        require 'views/layout/header.php';
        require 'views/layout/navbar.php';
        require 'views/layout/sidebar.php';
        require 'views/' . $nombre . '.php';
        require 'views/layout/footer.php';
    }
}

?>