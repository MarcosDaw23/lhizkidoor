<?php
class Ranking_Clases {
    private $id;
    private $clase;
    private $centro;
    private $puntuacionClase;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getClase() {
        return $this->clase;
    }

    public function getPuntuacionClase() {
        return $this->puntuacionClase;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setClase($clase) {
        $this->clase = $clase;
    }

    public function setPuntuacionClase($puntuacionClase) {
        $this->puntuacionClase = $puntuacionClase;
    }
}
?>
