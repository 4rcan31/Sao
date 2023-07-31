<?php
class users extends Migration{
    public function up(){
        echo $this->create("users", function($table){
            $table->id('user_id');
            $table->string("user_handle", 50)->notnull()->unique();
            $table->string("email_address", 50)->notnull()->unique();
            $table->string("first_name", 100)->notnull();
            $table->string("last_name", 100)->notnull();
            $table->char('phonenumber', 10)->unique();
            $table->createat();
            $table->primarykey('user_id');
        });
    }


    public function down(){
        echo $this->dropIfExist('users');
    }
}