<?php
class Ranking_Sectores {
    private $id;
    private $sectores;
    private $centro;
    private $puntuacionSector;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getSector() {
        return $this->sector;
    }

    public function getPuntuacionSector() {
        return $this->puntuacionSector;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSector($sector) {
        $this->sector = $sector;
    }

    public function setPuntuacionSector($puntuacionSector) {
        $this->puntuacionSector = $puntuacionSector;
    }
}
?>
