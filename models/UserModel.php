<?php

class UserModel extends ModelBase {
    
    private $username, $password, $role;

    public function __construct() {
        parent::__construct();
    }

    public function get($username) {
        try {
            $sql = "SELECT * FROM usuarios WHERE username=:username";
            $query = $this->prepare($sql);
            $query->execute([
                ':username' => $username
            ]);
            
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $this->username = $row['username'];
                $this->password = $row['password'];
                $this->role = $row['role'];
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo $e;
        }
    }
    
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getRole() {     return $this->role; }
}
?>