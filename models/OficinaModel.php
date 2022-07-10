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
     * Obtiene la tabla oficina
     */
    public function get($id) {
        try {
            $sql = "SELECT * FROM oficinas WHERE id=:id";
            $query = $this->prepare($sql);
            $query->execute([':id' => $id]);

            while($query && $row = $query->fetch(PDO::FETCH_ASSOC)) {
                $this->id = $row['id'];
                $this->oficina_id = $row['oficina_id'];
                $this->nombre = $row['nombre'];
                return true;
            }
            return false;

        } catch(PDOException $e) {
            echo $e;
        }
    }
    /**
     * Función que devuelve una lista de oficinas jefe
     * @return Array $data Lista de oficinas jefe
     */
    public function get_oficinas_jefe() {
        try {
            $sql = "SELECT id, nombre FROM oficinas WHERE oficina_id IS NULL ORDER BY nombre";
            $query = $this->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch(PDOException $e) {
            echo $e;
        }
    }

    /**
     * Función que devuelve la lista de oficinas
     * @return Array $data Lista de oficinas
     */
    public function get_lista_oficinas() {
        try {
            $sql = "SELECT ROW_NUMBER() OVER(ORDER BY nombre) AS nro, nombre, id FROM oficinas";
            $query = $this->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch(PDOException $e) {
            return $e;
        }
    }

    public function get_oficina_jefe() {
        try {
            $sql = "SELECT nombre FROM oficinas WHERE oficina_id = $this->oficina_id LIMIT 1";
            $query = $this->query($sql);
            
            $oficinaJefe = $query->fetch(PDO::FETCH_ASSOC);
            return $oficinaJefe;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public function get_suboficinas() {
        try {
            $sql = "SELECT nombre FROM oficinas WHERE oficina_id = :id";
            $query = $this->prepare($sql);
            $query->execute([':id' => $this->id]);

            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo $e;
        }
    }
    
    public function setNombre($nombre) {        $this->nombre = $nombre; }
    public function setOficinaId($oficina_id) { $this->oficina_id = $oficina_id; }
    public function getId() {                   return $this->id; }
    public function getNombre() {               return $this->nombre; }
    public function getOficinaId() {            return $this->oficina_id; }
}
?>