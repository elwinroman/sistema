<?php

class CargoModel extends ModelBase {
    // table cargo
    private $id_main;
    private $situacion;
    private $presupuesto;
    private $observacion;

    // table historial_cargo
    private $id;
    private $nombre;
    private $nro_plaza;
    private $clasificacion;
    private $codigo;
    private $ordenanza;
    private $fecha_ordenanza;
    private $oficina_id;
    private $cargo_id;

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

    public function setSituacion($situacion) {            $this->situacion = $situacion; }

    public function setNombre($nombre) {                  $this->nombre = $nombre; }
    public function setNroPlaza($nro_plaza) {             $this->nro_plaza = $nro_plaza; }
    public function setClasificacion($clasificacion) {    $this->clasificacion = $clasificacion; }
    public function setCodigo($codigo) {                  $this->codigo = $codigo; }
    public function setOrdenanza($ordenanza) {            $this->ordenanza = $ordenanza; }
    public function setFechaOrdenanza($fecha_ordenanza) { $this->fecha_ordenanza = $fecha_ordenanza; }
    public function setOficinaId($oficina_id) {           $this->oficina_id = $oficina_id; }

    public function getIdMain() { return $this->id_main; }
}

?>