<?php

class View {
    public function __construct() {
    }

    /**
     * Rendereiza la vista dentro del dashboard
     * @param{String} $nombre   Nombre del archivo de la vista
     *                          incluyendo la carpeta
     */
    public function render($nombre) {
        // require 'views/layout/header.php';
        require 'views/layout/header.php';
        require 'views/layout/navbar.php';
        require 'views/layout/sidebar.php';
        require 'views/' . $nombre . '.php';
        require 'views/layout/footer.php';
    }

    // Renderiza fuera del dashboard (login)
    public function render_login() {
        require 'views/layout/header.php';
        require 'views/login/login.php';
    }
}
?>