<?php

class ErrorController extends ControllerBase {
    
    public function __construct() {
        parent::__construct();
        
        // Redirecciona cuando el usuario no está autorizado
        if(!$this->session->accesoAutorizado()) {
            $this->redirect('');
        }
        $this->view->render('error/error-404');
    }
}
?>