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

    public function list() {
        $this->view->render('cargo/list');
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
            'oficina_id'    => null
        );

        if(isset($_POST['checkbox']) && isset($_POST['suboficina'])) {
            $cargo_data['oficina_id'] = $_POST['suboficina'];
        } else
            $cargo_data['oficina_id'] = $_POST['oficina-jefe'];

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
        $cargo->setOrdenanza($cargo_data['ordenanza']);
        $cargo->setFechaOrdenanza($cargo_data['fecha_ordenanza']);
        $cargo->setOficinaId($cargo_data['oficina_id']);

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

        if(!filter_var($data['nombre'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^([A-Za-zÀ-ÿ,.-]\s?){1,60}$/']]))
            return false;
        if(!filter_var($data['nro_plaza'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{3}$/']]))
            return false;
        if(!filter_var($data['clasificacion'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[A-Za-z-]{1,8}$/']]))
            return false;
        if(strlen($data['codigo']) > 0 && !filter_var($data['codigo'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{1,10}$/']]))
            return false;
        if(!filter_var($data['situacion'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^(o|O|p|P)$/']]))
            return false;
        if(!filter_var($data['ordenanza'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^([A-Za-zÀ-ÿ0-9,;(){}[\]*+¿?!¡:._-]\s?){1,50}$/']]))
            return false;
        if(!$this->util->validateDate($data['fecha_ordenanza']))
            return false;
        if(!filter_var($data['oficina_id'], FILTER_VALIDATE_INT))
            return false;

        return true;
    }
}
?>