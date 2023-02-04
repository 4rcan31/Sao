<?php


class Validate{
    public $datos;
    public $validates = [];
    public $msg = [];

    function __construct($datos){
        $this->datos = $datos;    
    }

    public function rule($rule, $campos, $otros = []){
        if($rule === 'required'){
            array_push($this->validates, $this->required($campos));
        }else if($rule === 'contain'){
            array_push($this->validates, $this->contain($campos, $otros));
        }else{
            res('Not validate named: '.$rule);
        }
    }

    public function required($campos){
        foreach($campos as $campo){
            if(!isset($this->datos[$campo])){
                array_push($this->msg, "El campo '$campo' no existe.");
                return false;
            }
            if((empty($this->datos[$campo]) && $this->datos[$campo] !== false) || $this->datos[$campo] === null){
                array_push($this->msg, "El campo $campo esta vacio.");
                return false;
            }
        }
        return true;
    }

    public function contain($sentenses, $contains){
        foreach($sentenses as $sentense){
            $input = $this->input($sentense);
            foreach($contains as $contain){
                if(!str_contains($input, $contain)){
                    array_push($this->msg, "$sentense no contiene $contain");
                    return false;
                }
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
        if(isset($this->datos[$index])){
            return $this->datos[$index];
        }
        echo 'El indice: "'.$index.'" no existe.';
        throw new Exception('El indice: "'.$index.'" no existe.'); 
    }  

    public function err(){
        return $this->msg;
    }
}