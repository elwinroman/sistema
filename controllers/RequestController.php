<?php

// Clase que controla todas las peticionas hechas desde Javascript
class RequestController extends ControllerBase {    
    public function __construct() {
        parent::__construct();

        if(!$this->session->isLoggedIn()) {
            $this->redirect('');
            return;
        }
    }

    // Controla el envío de la lista de oficinas jefe
    public function getoficinasjefe() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if(!isset($_POST['request'])) {
            $this->redirect('error');
            return;
        }

        $oficina = $this->loadModel('oficina');
        $res = $oficina->getoficinasjefe();

        if(count($res) > 0) {
            $data = [];

            foreach($res as $row) {
                $data[] = array(
                    'id'      => $row['id'], 
                    'nombre'  => $this->util->output_string($row['nombre']));
            }
            die(json_encode($data));

        } else die(json_encode(array('error' => true, 'mensaje' => 'No data')));
    }

    // Controla el envío de las lista de todas las oficinas
    public function getoficinas() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if(!isset($_POST['request'])) {
            $this-> redirect('error');
            return;
        }
        
        $oficina = $this->loadModel('oficina');
        $res = $oficina->getAll();

        // formatea datos para la vista
        if(count($res) > 0) {
            $data = [];
            
            foreach($res as $row) {
                $data[] = array(
                    '#'       => $row['nro'], 
                    'Oficina' => $this->util->output_string($row['nombre']),
                    'Chief'   => $this->util->output_string($row['oficina_jefe']),
                    'Ver'     => $row['id']);
            }
            die(json_encode($data));

        } else die(json_encode(array('error' => true, 'mensaje' => 'No data')));
    }
}
?>