<?php

class ModelBase {

    public function __construct() {
        $this->db = new Database();
    }

    // Función que prepara una consulta SQL y retorna una conexión PDO
    public function prepare($query) {
        return $this->db->connect()->prepare($query);
    }

    // Función que ejecuta una consulta SQL y retorna una conexión PDO
    public function query($query) {
        return $this->db->connect()->query($query);
    }
}

?>