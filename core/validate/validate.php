<?php


class Validate{
    public $datos = [];
    public $validates = [];
    public $msg = [];

    function __construct($datos){
        $this->datos = $datos;    
    }

    public function rule($rule, array $fields, mixed $otros = null){
        if($rule === 'required'){
            array_push($this->validates, $this->required($fields));
        }else if($rule === 'contain'){
            array_push($this->validates, $this->contain($fields, $otros));
        }else if($rule == 'email'){
            array_push($this->validates, $this->email($fields));
        }else if($rule == 'is'){
            array_push($this->validates, $this->is($fields, $otros));
        }else if($rule == 'in'){
            array_push($this->validates, $this->in($fields, $otros));
        }else if($rule == 'numeric'){
            array_push($this->validates, $this->numeric($fields));
        }else if($rule == 'phone'){
            array_push($this->validates, $this->phoneNumber($fields));
        }else{
            res('Not validate named: '.$rule);
        }
    }

    private function email($fields){
        return $this->contain($fields, ['@']);
    }

    private function numeric(array $fields){
        foreach($fields as $field){
            if(isset($this->datos[$field]) && is_numeric($this->datos[$field]) === false){
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
    
    

    public function required($fields){
        foreach($fields as $field){
            if(!isset($this->datos[$field])){
                array_push($this->msg, "El campo '$field' no existe.");
                return false;
            }
            if((empty($this->datos[$field]) && $this->datos[$field] !== false) || $this->datos[$field] === null){
                array_push($this->msg, "El campo $field esta vacio.");
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