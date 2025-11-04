<?php
class Ranking {
    private $id;
    private $rama;
    private $clase;
    private $sector;
    private $puntuacionRanking;

    public function __construct($id, $rama, $clase, $sector, $puntuacionRanking) {
        $this->id = $id;
        $this->rama = $rama;
        $this->clase = $clase;
        $this->sector = $sector;
        $this->puntuacionRanking = $puntuacionRanking;
    }

    public function getId() {
        return $this->id;
    }

    public function getRama() {
        return $this->rama;
    }

    public function getClase() {
        return $this->clase;
    }

    public function getSector() {
        return $this->sector;
    }

    public function getPuntuacionRanking() {
        return $this->puntuacionRanking;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setRama($rama) {
        $this->rama = $rama;
    }

    public function setClase($clase) {
        $this->clase = $clase;
    }

    public function setSector($sector) {
        $this->sector = $sector;
    }

    public function setPuntuacionRanking($puntuacionRanking) {
        $this->puntuacionRanking = $puntuacionRanking;
    }
}
?>
