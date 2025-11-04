<?php
class Clases {
    private $id;
    private $sector;
    private $nombre;
    private $puntuacionClase;

    public function __construct($id, $sector, $nombre, $puntuacionClase) {
        $this->id = $id;
        $this->sector = $sector;
        $this->nombre = $nombre;
        $this->puntuacionClase = $puntuacionClase;
    }

    public function getId() {
        return $this->id;
    }

    public function getSector() {
        return $this->sector;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPuntuacionClase() {
        return $this->puntuacionClase;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSector($sector) {
        $this->sector = $sector;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPuntuacionClase($puntuacionClase) {
        $this->puntuacionClase = $puntuacionClase;
    }
}
?>
