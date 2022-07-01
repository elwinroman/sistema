<?php

class ErrorController extends ControllerBase {
    
    public function __construct() {
        parent::__construct();
        
        // El usuario no esta autorizado 
        if(!$this->session->accesoAutorizado()) {
            $this->redirect('');
        }
        $this->view->render('error/error-404');
    }
}
?>