<?php


class Request{
    public static $method;
    public static $uri;
    public $data;


    
    protected $request; //Estos son todos los datos 
    public $path;

     public static function capture(){
        self::$method = $_SERVER["REQUEST_METHOD"];
        self::$uri = (parse_url('/'.trim($_SERVER["REQUEST_URI"], '/'), PHP_URL_PATH));
    }

    public static function uri(){
        return self::$uri;
    }

    public function getdata(){
        return $this->data;
    }

    public function data(){
        $server = import('server/server.php', true, '/core');
        $headers = $server->getallheaders();
        if(isset($headers['Content-Type'])){
            if($headers['Content-Type'] === 'application/json'){
                $this->data = json_decode(file_get_contents("php://input"));
                return json_decode(file_get_contents("php://input"));
            }else{
                $this->data = $_REQUEST;
                return $_REQUEST;
            }
        }
    }

    public function dataGET($routeDefinida){
        return $_GET;
    }

    public function dataMethod(){
        return $_REQUEST;
    }

}

