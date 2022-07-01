<?php

class Session {
    private $username = 'username';
    private $role = 'role';

    public function __construct() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function accesoAutorizado() {
        return isset($_SESSION[$this->username]);
    }

    // Elimina las sesiones
    public function closeSession() {
        session_unset();
        session_destroy();
    }

    public function setUsername($username) { $_SESSION[$this->username] = $username; }
    public function setRole($role) {         $_SESSION[$this->role] = $role; }
    public function getRole() {              return $_SESSION[$this->role]; }
}

?>