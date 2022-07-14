<?php

class ErrorController extends ControllerBase {
    public function __construct() {
        parent::__construct();
        
        if(!$this->session->isLoggedIn()) {
            $this->redirect('');
            return;
        }

        $this->view->render('error/error-404');
    }
}
?>