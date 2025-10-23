<?php 

class User {
    private $id;
    private $rol; 
    private $nombre;
    private $apellido;
    private $mail;
    private $password;
    private $centro;
    private $sector;
    private $clase;
    private $token;
    private $fechaConfirmacion;

    public function __construct($id, $rol, $nombre, $apellido, $mail, $password, $centro, $sector, $clase, $token, $fechaConfirmacion){
        $this->id = $id;
        $this->rol = $rol;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->mail = $mail;
        $this->password = $password;
        $this->centro = $centro;
        $this->sector = $sector;
        $this->clase = $clase;
        $this->token = $token;
        $this->fechaConfirmacion = $fechaConfirmacion;
    }

    //getterrs y setters de usuario
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
        return $this;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
        return $this;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getCentro() {
        return $this->centro;
    }

    public function setCentro($centro) {
        $this->centro = $centro;
        return $this;
    }

    public function getSector() {
        return $this->sector;
    }

    public function setSector($sector) {
        $this->sector = $sector;
        return $this;
    }

    public function getClase() {
        return $this->clase;
    }

    public function setClase($clase) {
        $this->clase = $clase;
        return $this;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    public function getFechaConfirmacion() {
        return $this->fechaConfirmacion;
    }

    public function setFechaConfirmacion($fechaConfirmacion) {
        $this->fechaConfirmacion = $fechaConfirmacion;
        return $this;
    }
}

?>