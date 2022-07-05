<?php

class OficinaController extends ControllerBase {
    
    public function __construct() {
        parent::__construct();

        // Redirecciona cuando el usuario no está autorizado
        if(!$this->session->accesoAutorizado())
            $this->redirect('');
    }

    public function formulario() {
        $this->view->render('oficina/crear-oficina');
    }
}
?>