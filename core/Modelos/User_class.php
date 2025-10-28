<?php
class User {
    private $id;
    private $rol;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $centro;
    private $sector;
    private $clase;
    private $puntuacionIndividual;
    private $token;
    private $fechaConfirmacion;

    public function __construct($id, $rol, $nombre, $apellido, $email, $password, $centro, $sector, $clase, $puntuacionIndividual,  $token, $fechaConfirmacion) {
        $this->id = $id;
        $this->rol = $rol;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->centro = $centro;
        $this->sector = $sector;
        $this->clase = $clase;
        $this->puntuacionIndividual = $puntuacionIndividual;
        $this->token = $token;
        $this->fechaConfirmacion = $fechaConfirmacion;
    }

// gets
    public function getId() {
        return $this->id;
    }
    public function getRol() {
        return $this->rol;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getCentro() {
        return $this->centro;
    }
    public function getSector() {
        return $this->sector;
    }
    public function getClase() {
        return $this->clase;
    }
    public function getpuntuacionIndividual() {
        return $this->puntuacionIndividual;
    }
    public function getToken() {
        return $this->token;
    }
    public function getFechaConfirmacion() {
        return $this->fechaConfirmacion;
    }

//settes
    public function setId($id) {
        $this->id = $id;
    }
    public function setRol($rol) {
        $this->rol = $rol;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setCentro($centro) {
        $this->centro = $centro;
    }
    public function setSector($sector) {
        $this->sector = $sector;
    }
    public function setClase($clase) {
        $this->clase = $clase;
    }
    public function setpuntuacionIndividual($puntuacionIndividual) {
        $this->puntuacionIndividual = $puntuacionIndividual;
    }
    public function setToken($token) {
        $this->token = $token;
    }
    public function setFechaConfirmacion($fechaConfirmacion) {
        $this->fechaConfirmacion = $fechaConfirmacion;
    }

}
?>
