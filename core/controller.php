<?php

class ControllerBase {
    
    public function __construct() {
        $this->view = new View();
    }

    /**
     * Función que carga un modelo en el controlador
     * 
     * @param{String}  $nombre_modelo    Nombre del archivo del modelo
     * @return{Object} $model            Retorna un modelo de tipo objeto
     */
    public function loadModel($nombre_modelo) {
        $file = 'models/' . $nombre_modelo . 'Model.php';
        if(file_exists($file)) {
            require_once $file;
            $classname = $nombre_modelo.'Model';
            $model = new $classname; 
            return $model;
        }
    }
}

?>