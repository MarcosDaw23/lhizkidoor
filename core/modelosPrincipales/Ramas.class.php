<?php 

class Ramas {
    private $id;
    private $nombre;
    private $puntuacionRama;

    public function __construct($id, $nombre, $puntuacionRama) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->puntuacionRama = $puntuacionRama;
    }

// get and set
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    public function getPuntuacionRama() {
        return $this->puntuacionRama;
    }

    public function setPuntuacionRama($puntuacionRama) {
        $this->puntuacionRama = $puntuacionRama;
        return $this;
    }
}
?>
 