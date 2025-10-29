<?php
class Diccionario {
    private $id;
    private $rama;
    private $cast;
    private $eusk1;
    private $eusk2;
    private $eusk3;
    private $ondo;
    private $definicion;

    public function __construct($id, $rama, $cast, $eusk1, $eusk2, $eusk3, $ondo, $definicion) {
        $this->id = $id;
        $this->rama = $rama;
        $this->cast = $cast;
        $this->eusk1 = $eusk1;
        $this->eusk2 = $eusk2;
        $this->eusk3 = $eusk3;
        $this->ondo = $ondo;
        $this->definicion = $definicion;
    }

    public function getId() {
        return $this->id;
    }

    public function getRama() {
        return $this->rama;
    }

    public function getCast() {
        return $this->cast;
    }

    public function getEusk1() {
        return $this->eusk1;
    }

    public function getEusk2() {
        return $this->eusk2;
    }

    public function getEusk3() {
        return $this->eusk3;
    }

    public function getOndo() {
        return $this->ondo;
    }

    public function getDefinicion() {
        return $this->definicion;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setRama($rama) {
        $this->rama = $rama;
    }

    public function setCast($cast) {
        $this->cast = $cast;
    }

    public function setEusk1($eusk1) {
        $this->eusk1 = $eusk1;
    }

    public function setEusk2($eusk2) {
        $this->eusk2 = $eusk2;
    }

    public function setEusk3($eusk3) {
        $this->eusk3 = $eusk3;
    }

    public function setOndo($ondo) {
        $this->ondo = $ondo;
    }

    public function setDefinicion($definicion) {
        $this->definicion = $definicion;
    }
}
?>
