<?php
class Sectores {
    private $id;
    private $nombre;
    private $rama;
    private $puntuacionTotal;

    public function __construct($id, $nombre, $rama, $puntuacionTotal) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->rama = $rama;
        $this->puntuacionTotal = $puntuacionTotal;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRama() {
        return $this->rama;
    }

    public function getPuntuacionTotal() {
        return $this->puntuacionTotal;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setRama($rama) {
        $this->rama = $rama;
    }

    public function setPuntuacionTotal($puntuacionTotal) {
        $this->puntuacionTotal = $puntuacionTotal;
    }
}
?>
