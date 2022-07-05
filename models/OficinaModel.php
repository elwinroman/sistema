<?php

class OficinaModel extends ModelBase {
    
    private $id;
    private $oficina_id;
    private $nombre;
    private $observacion;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Función que devuelve una lista de oficinas jefe
     * @return data Lista de oficinas jefe
     */
    public function get_oficinas_jefe() {
        try {
            $sql = "SELECT id, nombre FROM oficinas WHERE oficina_id IS NULL ORDER BY nombre";
            $query = $this->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch(PDOException $e) {
            return $e;
        }
    }
    
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getRole() {     return $this->role; }
}
?>