<?php
class tweets extends Migration {

    public function up() {
        echo $this->create("tweets", function($table) {
            $table->id('tweet_id');
            $table->int('user_id')->notnull();
            $table->string('tweet_text', 280)->notnull();
            $table->int('num_likes')->default(0);
            $table->int('num_retweets')->default(0);
            $table->string('num_coments')->default(0);
            $table->createat();
            $table->foreignkey('user_id')->references('users')->on('user_id');
            $table->primarykey('tweet_id');
        });
    }

    public function down() {
       echo  $this->dropIfExist("tweets");
    }

}