<?php

class ModelBase {
    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->connect();
    }

    // Prepara una consulta SQL y retorna una conexión PDO
    public function prepare($query) {
        return $this->pdo->prepare($query);
    }

    // Ejecuta una consulta SQL y retorna una conexión PDO
    public function query($query) {
        return $this->pdo->query($query);
    }

    // Retorna el ultimo ID insertado
    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>