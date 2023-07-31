<?php
class followers extends Migration {

    public function up() {
       echo $this->create("followers", function($table) {
            $table->int('follwer_id')->notnull();
            $table->int('following_id')->notnull();
            $table->foreignkey('follwer_id')->references('users')->on('user_id');
            $table->foreignkey('following_id')->references('users')->on('user_id');
            $table->primarykey('follwer_id', 'following_id');
        });
    }

    public function down() {
       echo $this->dropIfExist("followers");
    }

}