<?php
class Roles {
    private $id;
    private $rol;

    public function __construct($id, $rol) {
        $this->id = $id;
        $this->rol = $rol;
    }

    // gets
    public function getId() {
        return $this->id;
    }
    public function getRol() {
        return $this->rol;
    }

    //settes
    public function setId($id) {
        $this->id = $id;
    }
    public function setRol($rol) {
        $this->rol = $rol;
    }
}
?>