<?php


class Validate{
    public $datos = [];
    public $validates = [];
    public $msg = [];

    function __construct($datos){
        $this->datos = $datos;    
    }

    public function rule($rule, array $campos, mixed $otros = null){
        if($rule === 'required'){
            array_push($this->validates, $this->required($campos));
        }else if($rule === 'contain'){
            array_push($this->validates, $this->contain($campos, $otros));
        }else if($rule == 'email'){
            array_push($this->validates, $this->email($campos));
        }else if($rule == 'is'){
            array_push($this->validates, $this->is($campos, $otros));
        }else if($rule == 'in'){
            array_push($this->validates, $this->in($campos, $otros));
        }else if($rule == 'numeric'){
            array_push($this->validates, $this->numeric($campos));
        }else if($rule == 'phone'){
            array_push($this->validates, $this->phoneNumber($campos));
        }else{
            res('Not validate named: '.$rule);
        }
    }

    private function email($campos){
        return $this->contain($campos, ['@']);
    }

    private function numeric(array $campos){
        foreach($campos as $campo){
            if(isset($this->datos[$campo]) && is_numeric($this->datos[$campo]) === false){
                return false;
            }
        }
        return true;
    }


    private function in($needle, $array = null) {
        $haystack = ($array === null) ? $this->datos : $array;
    
        if (is_array($needle)) {
            return count(array_intersect($needle, $haystack)) > 0;
        } else {
            return in_array($needle, $haystack);
        }
    }
    

    private function is(mixed $data, string $type): bool {
        if ($type === 'number') {
            return is_numeric($data);
        }
        return gettype($data) === $type;
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

    public function equals(string ...$data) {
        return count(array_unique($data)) === 1;
    }
    

    public function contain($sentenses, $contains){
        foreach($sentenses as $sentense){
            $input = $this->input($sentense);
            if(!$input){
                return false;
            }
            foreach($contains as $contain){
                if(!str_contains($input, $contain)){
                    array_push($this->msg, "$sentense no contiene $contain");
                    return false;
                }
            }
        }
        return true;
    }


    function phoneNumber($phones) {
        $cleanedPhones = array_map(function($index) {
            $phone = $this->input($index);
            if (!$phone) {
                return false;
            }
            // Elimina todos los caracteres que no sean números o el signo "+"
            $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
            return $cleanPhone;
        }, $phones);
    
        // Verifica si todos los números de teléfono son válidos
        $isValid = array_reduce($cleanedPhones, function($isValid, $cleanPhone) {
            if ($cleanPhone === false) {
                return false; // Si uno de los números no se pudo obtener, consideramos que no es válido.
            }
            // Comprueba si el número de teléfono tiene el formato correcto
            return $isValid && preg_match('/^\+?[0-9]+$/', $cleanPhone) === 1;
        }, true);
    
        return $isValid;
    }
    

    public function validate(){
        foreach($this->validates as $validate){
            if($validate === false){
                return false;
                break;
            }
        }
        $this->setForNewValidate();
        return true;
    }

    public function input($index){
        if(isset($this->datos[$index])){
            return $this->datos[$index];
        }
        return false;
       /*  throw new Exception('El indice: "'.$index.'" no existe.');  */
    }  

    public function err(){
        return $this->msg;
    }

    public function setForNewValidate(){
        $this->msg = [];
        $this->validates = [];
    }
}