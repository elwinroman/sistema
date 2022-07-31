<?php

class CargoController extends ControllerBase {    
    public function __construct() {
        parent::__construct();

        if(!$this->session->isLoggedIn()) {
            $this->redirect('');
            return;
        }
    }

    public function new() {
        $this->view->render('cargo/new');
    }

    public function create() {        
        if(!$this->existsPOST(['nombre','nro-plaza','clasificacion','codigo','situacion','ordenanza',
                            'fecha-ordenanza','oficina-jefe'])) {
            $this->redirect('error');
        }

        // tratamiento de los datos
        $cargo_data = array(
            'nombre'        => $this->util->limpiar_cadena($_POST['nombre']),
            'nro_plaza'     => $this->util->reduce_multiple_space($_POST['nro-plaza']),
            'clasificacion' => $this->util->limpiar_cadena($_POST['clasificacion']),
            'codigo'        => $this->util->reduce_multiple_space($_POST['codigo']),
            'situacion'     => $_POST['situacion'],
            'ordenanza'     => $this->util->limpiar_cadena($_POST['ordenanza']),
            'fecha_ordenanza' => $_POST['fecha-ordenanza'],
            'oficina_jefe'  => $_POST['oficina-jefe'],  // id
            'suboficina'    => null     // id
        );

        if(isset($_POST['checkbox']) && isset($_POST['suboficina'])) {
            $cargo_data['suboficina'] = $_POST['suboficina'];
        }

        // validación de datos
        if(!$this->validate($cargo_data)) {
            $this->redirect('cargo/new');
            return;
        }

        // asignación de datos
        $cargo = $this->loadModel('cargo');     // este modelo incluye a las tablas cargo e historial_cargo

        $cargo->setNombre($cargo_data['nombre']);
        $cargo->setNroPlaza($cargo_data['nro_plaza']);
        $cargo->setClasificacion($cargo_data['clasificacion']);
        $cargo->setCodigo($cargo_data['codigo']);
        $cargo->setSituacion($cargo_data['situacion']);
        $cargo->setOrdenanza($cargo_data['situacion']);
        $cargo->setFechaOrdenanza($cargo_data['fecha_ordenanza']);
        $cargo->setOficinaId($cargo_data['oficina_jefe']);

        // insertar en la base de datos
        if($cargo->insert()) {
            $id = $cargo->getIdMain();
            $this->redirect('cargo/details&id='.$id);
            return;
        } else  {
            $this->redirect('cargo/new');
            return;
        }
    }

    public function details() {
        if(!isset($_GET['id'])) {
            $this->redirect('error');
            return;
        }

        $this->view->render('cargo/details');
    }

    /**
     * Valida los datos al crear o editar un cargo
     * @param  Array $data   Default: random var, lo importante es que reciba un array
     * @return Bool
     */
    public function validate($data = 'd8648364cf358ce9e920') {
        if(!is_array($data)) {
            $this->redirect('error');
            return;
        }

        return true;
    }
}
?>