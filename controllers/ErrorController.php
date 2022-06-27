<?php

class ErrorController extends ControllerBase {
    public function __construct() {
        parent::__construct();
        $this->view->render('error/error-404');
    }
}
?>