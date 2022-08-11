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
        
        $id = $_GET['id'];

        $cargo = $this->loadModel('cargo');
        
        if($cargo->get($id)) {

            // agrega más detalles al resultado (situación del cargo)
            if(strtolower($cargo->getSituacion()) == 'o') $situacion = 'O (Ocupado)';
            else if(strtolower($cargo->getSituacion()) == 'p') $situacion = 'P (Preventivo)';

            // agrega más detalles al resultado (clasificación del cargo)
            $clasificacion = strtolower($cargo->getClasificacion());
            switch($clasificacion) {
                case 'fp'   : $clasificacion = 'FP (Funcionario Público)'; break;
                case 'ec'   : $clasificacion = 'EC (Empleado de Confianza)'; break;
                case 'sp-ds': $clasificacion = 'SP-DS (Servidor Público Directivo Superior)'; break;
                case 'sp-ej': $clasificacion = 'SP-EJ (Servidor Público Ejecutivo)'; break;
                case 'sp-es': $clasificacion = 'SP-ES (Servidor Público Especialista)'; break;
                case 'sp-ap': $clasificacion = 'SP-AP (Servidor Público de Apoyo)'; break; 
            }

            $this->view->data = [
                'nombre'        => $this->util->output_string($cargo->getNombre()),
                'nro_plaza'     => $cargo->getNroPlaza(),
                'clasificacion' => $clasificacion,
                'codigo'        => $cargo->getCodigo(),
                'situacion'     => $situacion,
                'oficina'       => $this->util->output_string($cargo->getOficina()),
                'observacion'   => $cargo->getObservacion(),
                'oficina_id'    => $cargo->getOficinaId()
            ];

            // historial de cambios
            foreach($cargo->getHistorialCambios($id) as $row) {
                
                // si el cargo no pertenece a una oficina jefe, se define el campo como vacio
                if(is_null($row['oficina_jefe'])) $oficina_jefe = '';   
                else $oficina_jefe = $row['oficina_jefe'];

                $this->view->data_historial_cambio[] = [
                    'id'            => $row['id'],
                    'nombre'        => $this->util->output_string($row['nombre']),
                    'nro_plaza'     => $row['nro_plaza'],
                    'codigo'        => $row['codigo'],
                    'clasificacion' => mb_strtoupper($row['clasificacion']),
                    'oficina'       => $this->util->output_string($row['oficina']),
                    'ordenanza'     => mb_strtoupper($row['ordenanza']),
                    'fecha_ordenanza' => $this->util->localFormatDate($row['fecha_ordenanza']),
                    'oficina_id'    => $row['oficina_id'],
                    'oficina_jefe'  => $oficina_jefe
                ];

            }

        } else {
            $this->redirect('error');
        }

        $this->view->render('cargo/details');
    }

    // Añade o edita cambios en el historial
    public function addorupdatechanges() {
        if(!$this->existsPOST(['nombre','nro-plaza','clasificacion','codigo','ordenanza','fecha-ordenanza','oficina-jefe'])) $this->redirect('error');
        if(!isset($_GET['id-main'])) $this->redirect('error'); 
        if(!isset($_GET['op'])) $this->redirect('error');

        if($_GET['op'] === 'update') {
            if(!isset($_GET['id'])) $this->redirect('error');
            if(!filter_var($_GET['id'], FILTER_VALIDATE_INT)) $this->redirect('error');
        }
        
        $id_main = trim($_GET['id-main']);

        // tratamiento de los datos
        $cargo_data = array(
            'nombre'        => $this->util->limpiar_cadena($_POST['nombre']),
            'nro_plaza'     => $this->util->reduce_multiple_space($_POST['nro-plaza']),
            'clasificacion' => $this->util->limpiar_cadena($_POST['clasificacion']),
            'codigo'        => $this->util->reduce_multiple_space($_POST['codigo']),
            'ordenanza'     => $this->util->limpiar_cadena($_POST['ordenanza']),
            'fecha_ordenanza' => $_POST['fecha-ordenanza'],
            'cargo_id'      => $id_main,
            'oficina_id'    => null
        );

        if(isset($_POST['checkbox']) && isset($_POST['suboficina'])) {
            $cargo_data['oficina_id'] = $_POST['suboficina'];
        } else
            $cargo_data['oficina_id'] = $_POST['oficina-jefe'];

        // validación de datos
        if(!$this->validate($cargo_data)) {
            $this->redirect('cargo/details&id='.$id_main);
            return;
        }

        // asignación de datos
        $cargo = $this->loadModel('cargo');     // este modelo incluye a las tablas cargo e historial_cargo

        $cargo->setNombre($cargo_data['nombre']);
        $cargo->setNroPlaza($cargo_data['nro_plaza']);
        $cargo->setClasificacion($cargo_data['clasificacion']);
        $cargo->setCodigo($cargo_data['codigo']);
        $cargo->setOrdenanza($cargo_data['ordenanza']);
        $cargo->setFechaOrdenanza($cargo_data['fecha_ordenanza']);
        $cargo->setOficinaId($cargo_data['oficina_id']);
        $cargo->setCargoId($cargo_data['cargo_id']);

        if($_GET['op'] === 'add') {
            // inserta un nuevo cambio en el historial de cargo
            if($cargo->insertChanges()) {
                $this->redirect('cargo/details&id='.$id_main);
                return;
            } else $this->redirect('error');
        }  
        else if($_GET['op'] === 'update') {
            // modifica un cambio del historial de cargo
            $cargo->setId(trim($_GET['id']));

            if($cargo->updateChanges()) {
                $this->redirect('cargo/details&id='.$id_main);
                return;
            } else $this->redirect('error');
        }

    }

    public function deleteChanges() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if(!isset($_POST['request'])) $this->redirect('error');
        if(!isset($_POST['id'])) $this->redirect('error');

        $id = $_POST['id'];
        
        // validación
        if(!filter_var($id, FILTER_VALIDATE_INT)) $this->redirect('error');
        
        $cargo = $this->loadModel('cargo');
        
        if($cargo->deleteChanges($id)) die(json_encode(array('se ha eliminado correctamente')));
        else die(json_encode(array('error' => true, 'mensaje' => 'no se pudo eliminar')));
    }

    /**
     * Valida los datos al crear, añadir cambios o editar un cargo
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
        if(array_key_exists('situacion', $data)) { 
            if(!filter_var($data['situacion'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^(o|O|p|P)$/']]))
                return false;
        }
        if(!filter_var($data['ordenanza'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^([A-Za-zÀ-ÿ0-9,;(){}[\]*+¿?!¡:._-]\s?){1,50}$/']]))
            return false;
        if(!$this->util->validateDate($data['fecha_ordenanza']))
            return false;
        if(!filter_var($data['oficina_id'], FILTER_VALIDATE_INT))
            return false;
        if(array_key_exists('cargo_id', $data)) {
            if(!filter_var($data['cargo_id'], FILTER_VALIDATE_INT))
                return false;
        }

        return true;
    }
}
?>