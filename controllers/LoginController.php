<?php

class LoginController extends ControllerBase {    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // se muestra el login solo cuando el usuario no está logueado
        if($this->session->isLoggedIn()) {
            $this->redirect('');
            return;
        }

        $this->view->render_login();
    }

    public function autenticar() {
        if(!$this->existsPOST(['username', 'password'])) {
            $this->redirect('');
            return;
        }
        
        $user = $this->loadModel('user');
            
        // existe el usuario y su contraseña es correcta
        if($user->get($_POST['username']) && $_POST['password'] == $user->getPassword()) {
            $this->session->setUsername($user->getUsername());
            $this->session->setRole($user->getRole());
            
            $this->redirect('');
            return;
        } else {
            $this->redirect('');
            return;
        }
    }

    public function close() {
        $this->session->close();
        $this->redirect('');
    }
}
?>