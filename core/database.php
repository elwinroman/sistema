<?php

class Database {
    private $host, $user, $password, $db, $charset;
    
    public function __construct() {
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
        $this->db = DB_DB;
        $this->charset = DB_CHARSET;
    }

    public function connect() {
        try {
            $connection = "mysql:host=".$this->host .";dbname=".$this->db.";charset=".$this->charset;
            
            $options = [
                PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES  => false
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;

        } catch(PDOException $e) {
            print_r('Error conection: ' . $e->getMessage());
        }
    }
}
?>
