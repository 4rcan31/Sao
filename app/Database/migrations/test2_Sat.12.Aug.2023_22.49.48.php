<?php
class test2 extends Migration {
        
    public function up() {
        $this->create("test2", function($table) {
            
            
        $this->query('CREATE TABLE test2 (
            PersonID int,
            LastName varchar(255),
            FirstName varchar(255),
            Address varchar(255),
            City varchar(255)
        )');
        });
    }
        
    public function down() {
        $this->dropIfExist("test2");
    }
        
}