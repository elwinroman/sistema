<?php

class CargoModel extends ModelBase {
    // table cargo
    private $id_main, $situacion, $presupuesto, $observacion;

    // table historial_cargo
    private $id, $nombre, $nro_plaza, $clasificacion, $codigo, $ordenanza;
    private $fecha_ordenanza, $oficina_id, $cargo_id;

    // join tables
    private $oficina;

    public function __construct() {
        parent::__construct();
    }

    public function insert() {
        
        $success = false;

        try {
            $this->pdo->beginTransaction();

            $sql1 = "INSERT INTO cargo (id, situacion) VALUES (:id, :situacion)";
            $sql2 = "INSERT INTO historial_cargo (id, nombre, nro_plaza, clasificacion,
                        codigo, ordenanza, fecha_ordenanza, oficina_id, cargo_id) VALUES (
                        :id, :nombre, :nro_plaza, :clasificacion, :codigo, :ordenanza,
                        :fecha_ordenanza, :oficina_id, LAST_INSERT_ID()
            )";

            $query1 = $this->prepare($sql1);
            $query2 = $this->prepare($sql2);
            
            $query1->execute([
                ':id'        => null,
                ':situacion' => $this->situacion
            ]);
            $query2->execute([
                ':id'            => null,
                ':nombre'        => $this->nombre,
                ':nro_plaza'     => $this->nro_plaza,
                ':clasificacion' => $this->clasificacion,
                ':codigo'        => $this->codigo,
                ':ordenanza'     => $this->ordenanza,
                ':fecha_ordenanza' => $this->fecha_ordenanza,
                ':oficina_id'    => $this->oficina_id
            ]);

            // obtiene el id main del cargo despues de insertar en historial_cargo
            $this->id = $this->pdo->lastInsertId();
            $query = $this->prepare("SELECT cargo_id FROM historial_cargo WHERE id = :id LIMIT 1");
            $query->execute([':id' => $this->id]);
            $this->id_main = current($query->fetch());
            
            return $this->pdo->commit();

        } catch(PDOException $e) {
            echo $e;
            $this->pdo->rollBack();
        }
    }

    public function insertChanges() {
        try {
            $sql = "INSERT INTO historial_cargo (id, nombre, nro_plaza, clasificacion,
                        codigo, ordenanza, fecha_ordenanza, oficina_id, cargo_id) VALUES (
                        :id, :nombre, :nro_plaza, :clasificacion, :codigo, :ordenanza,
                        :fecha_ordenanza, :oficina_id, :cargo_id)";

            $query = $this->prepare($sql);
            $query->execute([
                ':id'            => null,
                ':nombre'        => $this->nombre,
                ':nro_plaza'     => $this->nro_plaza,
                ':clasificacion' => $this->clasificacion,
                ':codigo'        => $this->codigo,
                ':ordenanza'     => $this->ordenanza,
                ':fecha_ordenanza' => $this->fecha_ordenanza,
                ':oficina_id'    => $this->oficina_id,
                ':cargo_id'      => $this->cargo_id
            ]);

            return $query;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT cmain.id, c.nro_plaza, c.nombre, c.clasificacion, c.codigo, o.nombre AS oficina FROM cargo AS cmain
                    LEFT JOIN historial_cargo AS c ON cmain.id = c.cargo_id 
                    AND c.fecha_ordenanza = (SELECT MAX(fecha_ordenanza) FROM historial_cargo WHERE cargo_id = cmain.id)
                    LEFT JOIN oficina AS o ON c.oficina_id = o.id";
            $query = $this->query($sql);

            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo $e;
        }
    }

    /** 
     * Obtiene un cargo y setea los datos
     * @param  String $id
     * @return Bool
     */
    public function get($id) {
        try {
            $sql = "SELECT cmain.situacion, cmain.presupuesto, cmain.observacion, c.nombre, c.nro_plaza, 
                    c.codigo, c.clasificacion, c.oficina_id, o.nombre AS oficina, c.fecha_ordenanza FROM historial_cargo AS c
                    LEFT JOIN oficina AS o ON c.oficina_id = o.id
                    LEFT JOIN cargo AS cmain ON c.cargo_id = cmain.id
                    WHERE c.cargo_id = ? AND c.fecha_ordenanza = (
                        SELECT MAX(fecha_ordenanza) FROM historial_cargo WHERE cargo_id = ?) LIMIT 1";
            
            $query = $this->prepare($sql);
            $query->execute([$id, $id]);

            while($query && $row = $query->fetch(PDO::FETCH_ASSOC)) {
                $this->situacion = $row['situacion'];
                $this->presupuesto = $row['presupuesto'];
                $this->observacion = $row['observacion'];

                $this->nombre = $row['nombre'];
                $this->nro_plaza = $row['nro_plaza'];
                $this->codigo = $row['codigo'];
                $this->clasificacion = $row['clasificacion'];
                $this->observacion = $row['observacion'];
                $this->oficina_id = $row['oficina_id'];

                $this->oficina = $row['oficina'];
                
                return true;
            }

            return false;

        } catch(PDOException $e) {
            echo $e;
        }
    }

    /**
     * Obtiene la lista de cambios de un cargo
     * @param  String $id
     * @return Array
     */
    public function getHistorialCambios($id) {
        try {
            $sql = "SELECT c.id, c.nombre, c.nro_plaza, c.codigo, c.clasificacion, o.nombre AS oficina, c.ordenanza, 
                    c.fecha_ordenanza, c.oficina_id, o.oficina_id AS oficina_jefe FROM historial_cargo AS c
                    LEFT JOIN oficina AS o ON c.oficina_id = o.id
                    WHERE c.cargo_id = :id ORDER BY c.fecha_ordenanza DESC";

            $query = $this->prepare($sql);
            $query->execute([':id' => $id]);

            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo $e;
        }
    }

    public function setSituacion($situacion) {            $this->situacion = $situacion; }

    public function setNombre($nombre) {                  $this->nombre = $nombre; }
    public function setNroPlaza($nro_plaza) {             $this->nro_plaza = $nro_plaza; }
    public function setCodigo($codigo) {                  $this->codigo = $codigo; }
    public function setClasificacion($clasificacion) {    $this->clasificacion = $clasificacion; }
    public function setOrdenanza($ordenanza) {            $this->ordenanza = $ordenanza; }
    public function setFechaOrdenanza($fecha_ordenanza) { $this->fecha_ordenanza = $fecha_ordenanza; }
    public function setOficinaId($oficina_id) {           $this->oficina_id = $oficina_id; }
    public function setCargoId($cargo_id) {               $this->cargo_id = $cargo_id; }

    public function getIdMain() {        return $this->id_main; }
    public function getSituacion() {     return $this->situacion; }
    public function getObservacion() {   return $this->observacion; }
    
    public function getNombre() {        return $this->nombre; }
    public function getNroPlaza() {      return $this->nro_plaza; }
    public function getClasificacion() { return $this->clasificacion; }
    public function getCodigo() {        return $this->codigo; }
    public function getOficinaId() {     return $this->oficina_id; }
    public function getCargoId() {     return $this->cargo_id; }

    public function getOficina() {       return $this->oficina; } 
}

?>