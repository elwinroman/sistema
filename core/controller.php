<?php

class ControllerBase {
    
    public function __construct() {
        $this->view = new View();
        $this->session = new Session();
    }

    /**
     * Función que carga un modelo en el controlador
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

    /**
     * Función que comprueba la existencia de las variables POST enviadas
     * @param{Array} $params
     * @return{Bool} Retorna falso si hay una variable $_POST que no existe
     *               caso contrario retorna verdadero
     */
    protected function existsPOST($params) {
        foreach($params as $param) {
            if(!isset($_POST[$param])) 
                return false;
        }
        return true;
    }

    protected function redirect($url) {
        header("Location: " . URL_BASE . $url);
    }
}

?>