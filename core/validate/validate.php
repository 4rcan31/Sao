<?php


class Validate{
    public $datos;
    public $validates = [];

    function __construct($datos){
        $this->datos = $datos;    
    }

    public function rule($rule, $campos){
        if($rule === 'required'){
            array_push($this->validates, $this->required($campos));
        }else{
            res('Not validate named: '.$rule);
        }
    }

    public function required($campos){
        foreach($campos as $campo){
            if(!isset($this->datos[$campo]) || empty($this->datos[$campo])){
                return false;
            }
        }
        return true;
    }

    public function validate(){
        foreach($this->validates as $validate){
            if($validate === false){
                return false;
                break;
            }
        }
        return true;
    }

    public function input($index){
        return $this->datos[$index];
    }
}