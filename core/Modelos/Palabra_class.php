<?php
class Palabra {
    private $id;
    private $rama;
    private $euskera;
    private $castellano;
    private $definicion;

    public function __construct() {
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getRama() {
        return $this->rama;
    }

    public function getEuskera() {
        return $this->euskera;
    }

    public function getCastellano() {
        return $this->castellano;
    }

    public function getDefinicion() {
        return $this->definicion;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setRama($rama) {
        $this->rama = $rama;
    }

    public function setEuskera($euskera) {
        $this->euskera = $euskera;
    }

    public function setCastellano($castellano) {
        $this->castellano = $castellano;
    }

    public function setDefinicion($definicion) {
        $this->definicion = $definicion;
    }
}
?>

