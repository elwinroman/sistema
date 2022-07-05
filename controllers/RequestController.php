<?php

// Clase que controla todas las peticionas Ajax desde Javascript
class RequestController extends ControllerBase {
    
    public function __construct() {
        parent::__construct();

        // Redirecciona cuando el usuario no está autorizado
        if(!$this->session->accesoAutorizado())
            $this->redirect('');
    }

    // Función que controla el envío de la lista de oficinas jefe
    public function getOficinasJefe() {
        $data = ["success"=>false];
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if(isset($_POST['request'])) {
            $oficina_model = $this->loadModel('oficina');
            $data = $oficina_model->get_oficinas_jefe();

            if(count($data) > 0) die(json_encode($data));
            else die(json_encode(array('error' => true, 'mensaje' => 'No data')));
        } else {
            $this->redirect('error');
        }
    }
}
?>