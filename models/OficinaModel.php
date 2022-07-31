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
            $sql = "INSERT INTO oficina (id, oficina_id, nombre) VALUES(:id, :oficina_id, :nombre)";
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

    public function update() {
        try {
            $sql = "UPDATE oficina SET nombre = :nombre, oficina_id = :oficina_id, observacion = :observacion WHERE id = :id";
            $query = $this->prepare($sql);
            $query->execute([
                'id'         => $this->id,
                'nombre'     => $this->nombre,
                'oficina_id' => $this->oficina_id,
                'observacion'=> $this->observacion
            ]);

            return $query;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    /**
     * Obtiene una oficina y setea los datos
     * @param  String $id
     * @return Bool
     */
    public function get($id) {
        try {
            $sql = "SELECT * FROM oficina WHERE id = :id";
            $query = $this->prepare($sql);
            $query->execute([':id' => $id]);

            while($query && $row = $query->fetch(PDO::FETCH_ASSOC)) {
                $this->id = $row['id'];
                $this->oficina_id = $row['oficina_id'];
                $this->nombre = $row['nombre'];
                $this->observacion = $row['observacion'];
                return true;
            }
            return false;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT ROW_NUMBER() OVER(ORDER BY nombre) AS nro, sub.id, sub.nombre, chief.nombre AS oficina_jefe
                    FROM oficina AS sub LEFT JOIN oficina AS chief ON sub.oficina_id = chief.id";
            $query = $this->query($sql);
            
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    // Devuelve una lista de oficinas jefe (fetch request)
    public function getoficinasjefe() {
        try {
            $sql = "SELECT id, nombre FROM oficina WHERE oficina_id IS NULL ORDER BY nombre";
            $query = $this->query($sql);
         
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    /** 
     * Devuelve una lista de suboficinas de una oficina-jefe (fetch request)
     * @param String $id Identificador de oficina-jefe
     */
    public function getsuboficinas($id) {
        try {
            $sql = "SELECT id, nombre FROM oficina WHERE oficina_id = :id";
            $query = $this->prepare($sql);
            $query->execute([':id' => $id]);

            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public function get_oficinajefe() {
        try {
            $sql = "SELECT nombre FROM oficina WHERE id = :id LIMIT 1";
            $query = $this->prepare($sql);
            $query->execute([ 'id' => $this->oficina_id]);
            
            $oficinaJefe = $query->fetch(PDO::FETCH_ASSOC);
            return $oficinaJefe;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    // Obtiene lista de nombres de suboficinas 
    public function get_suboficinas() {
        try {
            $sql = "SELECT nombre FROM oficina WHERE oficina_id = :id";
            $query = $this->prepare($sql);
            $query->execute([':id' => $this->id]);

            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo $e;
        }
    }
    
    public function setId($id) {                    $this->id = $id; }
    public function setNombre($nombre) {            $this->nombre = $nombre; }
    public function setOficinaId($oficina_id) {     $this->oficina_id = $oficina_id; }
    public function setObservacion($observacion) {  $this->observacion = $observacion; }
    public function getId() {                       return $this->id; }
    public function getNombre() {                   return $this->nombre; }
    public function getOficinaId() {                return $this->oficina_id; }
    public function getObservacion() {              return $this->observacion; }
}
?>