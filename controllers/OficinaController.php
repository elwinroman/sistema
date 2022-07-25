<?php

class OficinaController extends ControllerBase {    
    public function __construct() {
        parent::__construct();

        if(!$this->session->isLoggedIn()) {
            $this->redirect('');
            return;
        }
    }

    public function new() {
        $this->view->render('oficina/new');
    }

    public function list() {
        $this->view->render('oficina/list');
    }

    public function create() {
        if(!$this->existsPOST(['nombre', 'tipo-oficina'])) {
            $this->redirect('error');
            return;
        }

        // tratamiento de los datos (normalización)
        $oficina_data = array(
            'nombre'       => $this->util->limpiar_cadena($_POST['nombre']),
            'tipo_oficina' => strtolower($_POST['tipo-oficina']),
            'oficina_id'   => null,
            'observacion'  => null
        );
        
        if($oficina_data['tipo_oficina'] == 'suboficina') 
            $oficina_data['oficina_id'] = $_POST['oficina-jefe'];

        // validación de datos
        if(!$this->validate($oficina_data)) {
            $this->redirect('oficina/new');
            return;
        }

        // proceso para insertar en la base de datos
        $oficina = $this->loadModel('oficina');
        $oficina->setNombre($oficina_data['nombre']);
        $oficina->setOficinaId($oficina_data['oficina_id']);

        // devolución de resultados
        if($result = $oficina->insert()) {
            $id = $oficina->getId();
            $this->redirect('oficina/details&id='.$id);
            return;
        } else {
            $this->redirect('oficina/new');
            return;
        }
    }

    public function update() {
        if(!$this->existsPOST(['nombre', 'tipo-oficina', 'observacion']) && !isset($_GET['id'])) {
            $this->redirect('error');
            return;
        }
        
        // tratamiento de los datos (normalización)
        $oficina_data = array(
            'nombre'       => $this->util->limpiar_cadena($_POST['nombre']),
            'tipo_oficina' => strtolower($_POST['tipo-oficina']),
            'oficina_id'   => null,
            'observacion'  => $this->util->reduce_multiple_space($_POST['observacion'])
        );

        if($oficina_data['tipo_oficina'] == 'suboficina') 
            $oficina_data['oficina_id'] = $_POST['oficina-jefe'];

        // validación de datos
        if(!$this->validate($oficina_data)) {
            $this->redirect('oficina/details&id='.$_GET['id']);
            return;
        }
        
        // proceso para insertar en la base de datos
        $oficina = $this->loadModel('oficina');
        $oficina->setId($_GET['id']);
        $oficina->setNombre($oficina_data['nombre']);
        $oficina->setOficinaId($oficina_data['oficina_id']);
        $oficina->setObservacion($oficina_data['observacion']);
        
        if($result = $oficina->update()) {
            $id = $oficina->getId();
            $this->redirect('oficina/details&id='.$id);
            return;
        }
    }

    public function details() {
        if(!isset($_GET['id'])) {
            $this->redirect('error');
            return;
        }

        $id = $_GET['id'];
        $oficina = $this->loadModel('oficina');

        if($oficina->get($id)) {
            $this->view->data = [
                'id'         => $oficina->getId(),
                'nombre'     => $this->util->output_string($oficina->getNombre()),
                'oficina_id' => $oficina->getOficinaId(),
                'observacion'=> $oficina->getObservacion()
            ];
            
            // obtiene oficina_jefe (si es suboficina)
            if($oficina->getOficinaId() != null) {
                $this->view->tipoOficina = "ÓRGANO";
                $oficinaJefe = $oficina->get_oficinajefe();
                
                $this->view->oficina = $this->util->output_string($oficinaJefe['nombre']);

            // obtiene suboficinas (si es oficina jefe)
            } else {
                $this->view->tipoOficina = 'UNIDADES ORGÁNICAS';
                $suboficinas = $oficina->get_suboficinas();

                if(count($suboficinas) > 0) {
                    foreach($suboficinas as $sub) {
                        $this->view->oficina[] = array('nombre' => $this->util->output_string($sub['nombre']));
                    }

                } else
                    $this->view->oficina = 'No hay unidades orgánicas registradas todavía';
            }

            // obtiene cargos
            // $cargos = $oficina->getCargos();
            $cargos = [];
            if(count($cargos) > 0) {
                $this->view->cargos = null;
            } else {
                $this->view->cargos = 'No hay cargos registrados todavia';
            }

            $this->view->render('oficina/details');

        } else  {
            $this->redirect('error');
            return;
        }
    }

    /**
     * Valida los datos al crear o editar una oficina
     * @param  Array $data   Default: random var, lo importante es que reciba un array
     * @return Bool
     */
    public function validate($data = 'd8648364cf358ce9e920') {
        if(!is_array($data)) {
            $this->redirect('error');
            return;
        }

        $regx_name = array("options" => array("regexp" => "/^([A-Za-zÀ-ÿ,.-]\s?){1,60}$/"));
        $regx_nota = array("options" => array("regexp" => "/^([A-Za-zÀ-ÿ0-9,;(){}[\]*+¿?!¡:._-]\s?){1,200}$/"));

        if(!filter_var($data['nombre'], FILTER_VALIDATE_REGEXP, $regx_name))
            return false;
        if($data['tipo_oficina'] == 'suboficina' && !filter_var($data['oficina_id'], FILTER_VALIDATE_INT))
            return false;
        if(!is_null($data['nota']) && !filter_var($data['nota'], FILTER_VALIDATE_REGEXP, $regx_nota))
            return false;
        return true;
    }
}
?>