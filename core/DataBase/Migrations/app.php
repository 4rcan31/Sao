<?php 

require "table.php";
class Migration extends DataBase{
    
    
    public function create(string $nameTable, callable $function){
        $table = new Table($nameTable, 'create');
        $function($table);
        return $table->querySql();
    }

    public function dropIfExist(string $nameTable){
        $table = new Table($nameTable, 'delete');
      //  return $this->query($table->querySql()); //Se ejecuta la query contruida
        return $table->querySql();
    }
}