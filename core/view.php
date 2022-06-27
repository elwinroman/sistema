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
        require 'views/' . $nombre . '.php';
    }
}

?>