<?php

class OficinaModel extends ModelBase {
    
    private $id;
    private $oficina_id;
    private $nombre;
    private $observacion;

    public function __construct() {
        parent::__construct();
    }

    public function insert() {
        try {
            $sql = "INSERT INTO oficinas(id, oficina_id, nombre) VALUES(:id, :oficina_id, :nombre)";
            $query = $this->prepare($sql);
            $query->execute([
                ':id'         => null,
                ':oficina_id' => $this->oficina_id,
                ':nombre'     => $this->nombre
            ]);
            
            if($query) {
                $this->id = $this->getLastInsertId();
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo $e;
        }
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
    
    public function setNombre($nombre) {        $this->nombre = $nombre; }
    public function setOficinaId($oficina_id) { $this->oficina_id = $oficina_id; }
    public function getId() {                   return $this->id; }
    public function getNombre() {               return $this->nombre; }
    public function getOficinaId() {            return $this->oficina_id; }
}
?>