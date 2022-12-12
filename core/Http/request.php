<?php


class Request{
    public static $method;
    public static $uri;


    
    protected $request; //Estos son todos los datos 
    public $path;

     public static function capture(){
        self::$method = $_SERVER["REQUEST_METHOD"];
        self::$uri = (parse_url('/'.trim($_SERVER["REQUEST_URI"], '/'), PHP_URL_PATH));
    }

    public static function uri(){
        return self::$uri;
    }


    public function data(){
        if(self::$method == 'GET'){
            return $this->dataGET('ESTA ES UNA RUTA XD');
        }else{
            return $this->dataMethod();
        }
    }

    public function dataGET($routeDefinida){
        return $_GET;
    }

    public function dataMethod(){
        return $_REQUEST;
    }

}

