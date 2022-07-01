<?php

class LoginController extends ControllerBase {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Se muestra solo cuando el usuario no está logueado
        if($this->session->accesoAutorizado())
            $this->redirect('');

        $this->view->render_login();
    }

    public function autenticar() {
        $params = ['username', 'password']; 
        
        if($this->existsPOST($params)) {
            $user_model = $this->loadModel('user');
            
            // Existe el usuario y su contraseña es correcta
            if($user_model->get($_POST['username']) && $_POST['password'] == $user_model->getPassword()) {
                $this->session->setUsername($user_model->getUsername());
                $this->session->setRole($user_model->getRole());
                $this->redirect('');
            } else
                $this->redirect('');
        } else
            $this->redirect('');
    }

    public function close() {
        $this->session->closeSession();
        $this->redirect('');
    }
}
?>