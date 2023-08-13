<?php
class followers extends Migration {

    public function up() {
/*         $this->create("followers", function($table) {
            $table->int('follwer_id')->notnull();
            $table->int('following_id')->notnull();
            $table->foreignkey('follwer_id')->references('users')->on('user_id');
            $table->foreignkey('following_id')->references('users')->on('user_id');
            $table->primarykey('follwer_id', 'following_id');
        }); */

        $this->query('CREATE TABLE Persons (
            PersonID int,
            LastName varchar(255),
            FirstName varchar(255),
            Address varchar(255),
            City varchar(255)
        )');
    }

    public function down() {
        $this->dropIfExist("Persons");
    }

}