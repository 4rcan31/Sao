<?php 
class Connection{
    protected $connection = null;

    public function __construct(){
        try{
            $link = new PDO(
                "mysql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_DATABASE'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
            );
            $link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $link->exec('set names utf8');
            $this->connection = $link;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}