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

    public function crear() {
        $params = ['nombre', 'tipo-oficina'];

        if($this->existsPOST($params)) {
            // Tratamiento de los datos (normalizar)
            $oficina_data = array(
                'nombre'       => $this->util->limpiar_cadena($_POST['nombre']),
                'tipo_oficina' => strtolower($_POST['tipo-oficina']),
                'oficina_id'   => null
            );
            if($oficina_data['tipo_oficina'] == 'suboficina') 
                $oficina_data['oficina_id'] = $_POST['oficina-jefe'];

            // Validación de datos
            if(!$this->validate($oficina_data)) {
                #! Mensaje de error aqui
                $this->redirect('oficina/formulario');
            }
            var_dump($oficina_data);
            die();
            // Proceso para insertar en la base de datos
            $oficina_model = $this->loadModel('oficina');
            $oficina_model->setNombre($oficina_data['nombre']);
            $oficina_model->setOficinaId($oficina_data['oficina_id']);
            $res = $oficina_model->insert();

            // Devolución de resultados
            if($res) {
                $id = $oficina_model->getId();
                #! Mensaje de success aqui
                $this->redirect('oficina/mostrar&id='.$id);
            } else {
                #! Mensaje de error aqui
                $this->redirect('oficina/formulario');
            }
        } else {
            $this->redirect('error');
        }
    }

    public function mostrar() {
        $this->view->render('oficina/mostrar-oficina');
    }

    /**
     * Función que valida los datos al crear una oficina
     * @param array $data
     */
    public function validate($data) {
        $regx_name = array("options" => array("regexp" => "/^([A-Za-zÀ-ÿ]\s?)+$/"));
        if(!filter_var($data['nombre'], FILTER_VALIDATE_REGEXP, $regx_name))
            return false;
        if($data['tipo_oficina'] == 'suboficina' && !filter_var($data['oficina_id'], FILTER_VALIDATE_INT))
            return false;
        return true;
    }
}
?>