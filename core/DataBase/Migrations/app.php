<?php 

require "table.php";
class Migration extends ORM{
    
    
    public function create(string $nameTable, callable $function){
        $table = new Table($nameTable, 'create');
        $function($table);
        return $table->querySql();
    }

    public function dropIfExist(string $nameTable){
        $table = new Table($nameTable, 'delete');
        return $table->querySql();
    }
}