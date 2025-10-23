<?php 

class Rol {
    private $id;
    private $rol;

    public function __construct($id, $rol){
        $this->id = $id;
        $this->rol = $rol;
    }

    // getters
    public function getId(){
        return $this->id;
    }

    public function getrol(){
        return $this->rol;
    }

       // setters
    public function setId(){
        return $this->id;
    }

    public function setrol(){
        return $this->rol;
    }


}
