<?php
    class Sectores{
        private $id;
        private $name;
        private $family;
        private $total_puntuation;

        public function __construct($id, $name, $family, $total_puntuation){
            $this->id=$id;
            $this->name=$name;
            $this->family=$family;
            $this->total_puntuation=$total_puntuation;
        }

        // getters
        public function getId(){
            return $this->id;
        }

        public function getName(){
            return $this->name;
        }

        public function getFamily(){
            return $this->family;
        }

        public function getTotal_Puntuation(){
            return $this->total_puntuation;
        }

        // setters
        public function setId($id){
            $this->id=$id;
        }

        public function setName($name){
            $this->name=$name;
        }

        public function setFamily($family){
            $this->family=$family;
        }

        public function setTotal_Puntuation($total_puntuation){
            $this->total_puntuation=$total_puntuation;
        }

    }


?>