<?php 

class Diccionaro {
    private $id;
    private $rama;
    private $sector;
    private $clase;
    private $puntuacionRanking;
 

     public function __construct($id, $rama, $sector, $clase, $puntuacionRanking) {
        $this->id = $id;
        $this->rama = $rama;
        $this->sector = $sector;
        $this->clase = $clase;
        $this->puntuacionRanking = $puntuacionRanking;
    }

    //get and set
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getRama() {
        return $this->rama;
    }

    public function setRama($rama) {
        $this->rama = $rama;
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

    public function getPuntuacionRanking() {
        return $this->puntuacionRanking;
    }

    public function setPuntuacionRanking($puntuacionRanking) {
        $this->puntuacionRanking = $puntuacionRanking;
        return $this;
    }
}
?>