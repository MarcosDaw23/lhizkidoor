<?php 

class Clases {
    private $id;
    private $sector;
    private $nombre;
    private $puntuacion_clase;

    public function __construct($id, $sector, $nombre, $puntuacion_clases){
        $this->id = $id;
        $this->sector = $sector;
        $this->nombre = $nombre;
        $this->puntuacion_clases;
    }

    // getters
    public function getId(){
        return $this->id;
    }

    public function getsector(){
        return $this->sector;
    }

    public function getnombre(){
        return $this->nombre;
    }

    public function getpuntuacio_clases(){
        return $this->puntuacion_clases;
    }

       // setters
    public function setId(){
        return $this->id;
    }

    public function setsector(){
        return $this->sector;
    }

    public function setnombre(){
        return $this->nombre;
    }

    public function setpuntuacion_clases(){
        return $this->puntuacion_clases;
    }


}