<?php

class Table{

    /* 
        CONFIGURACION DE LA CLASE
    */
    public string $sql = "";
    public int $count = 0;
    public array $medaDataExecuted = [];
    public string $tempLast = "";
    public string $nameTable = "";
    public string $type = "";

    public function __construct($nameTable, $type = ""){
        $this->type = $type;
        $type == 'create' ? $this->sql = $this->sql."CREATE TABLE ".$nameTable." (" : 
                            $this->sql = $this->sql."SET FOREIGN_KEY_CHECKS=0; DROP TABLE IF EXISTS  `$nameTable`";
    }

    public function __destruct(){ //Esta funcion siempre se ejecuta de ultimo
        $this->type == 'create' ? $this->sql = $this->sql.")" : null;
        $this->sql = $this->sql."; ";
    }


    /* 
        seteadores
    */
    public function set($new, $newline = false){
        if($newline && $this->count == 0){ //Aca ya se que es una nueva columna y ademas, es la primer columna hecha
            $this->count = $this->count + 1; //Aca le digo que la primera columna ya existio por lo tanto, ya no habran mas primeras columnas
            $this->sql = $this->sql."$new";
        }else if($newline && $this->count > 0){ //Aca se que es una nueva columna pero no es la primera
            $this->sql = $this->sql.",$new";
        }else if(!$newline){ //Aca pues se que no es una nueva columna, solamente es un atributo
            $this->sql = $this->sql." $new";
        }
    }

    public function setMetaData($function, $columName){
        $this->medaDataExecuted = [
            'function' => $function,
            'colum' => $columName
        ];
    }

    /* 
        Columnas por default
    */

    public function id($nameColum = 'id'){
        $this->int($nameColum)->notnull()->autoincrement();
        return $this;
    }

    public function createat($nameColum = 'create_at'){
        $this->timestamp($nameColum)->notnull()->default('NOW()');
    }


    /* 
        Configuracion de columnas
    */
    public function int($colum){
        $this->set("$colum INT", true);   
        $this->setMetaData('int', $colum);
        return $this;
    }

    public function string($colum, $capacity = 255){
        //$capacity > 255 ? $capacity = 255 : $capacity = $capacity; //No estoy seguro de esta linea la verdad
        $this->set("$colum VARCHAR($capacity)", true);
        $this->setMetaData('string', $colum);
        return $this;
    }

    public function char($colum, $capacity = 255){
        $this->set($colum." CHAR($capacity)", true);
        return $this;
    }

    public function timestamp($colum){
        $this->set("$colum TIMESTAMP", true);
        return $this;
    }



    /* 
        Atributos
    */

    public function default($function){
        $this->set("DEFAULT($function)");
        return $this;
    }

    public function notnull(){
        $this->set("NOT NULL");
        return $this;
    }

    public function autoincrement(){
        $this->set("AUTO_INCREMENT");
        return $this;
    }

    public function unique(){
        $this->set("UNIQUE");
        return $this;
    }

    /* 
        Relaciones base de datos
    */

    public function primarykey(...$columsname){
        $this->set('PRIMARY KEY('.implode(',', $columsname).')', true);
        return $this;
    }

    public function foreignkey($colum){
        $this->set('FOREIGN KEY('.$colum.")", true);
        return $this;
    }

    public function references($table){
        $this->set("REFERENCES $table(");
        return $this;
    }

    public function on($colum){
        $this->set($colum.")");
        return $this;
    }


    /* 
        Debug
    */

    public function querySql(){
        $this->__destruct();
        return $this->sql;
    }
}