<?php


class Request{
    protected static $method;
    protected static $uri;
    protected static $request;

    static public function capture(){
        self::$method = $_SERVER["REQUEST_METHOD"];
        self::$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function request(){
        return self::$request;
    }

    static public function data($route){
        $method = self::$method;
        if($method == 'GET'){
           self::$request = self::getDataGET($route);
        }elseif($method == 'POST'){
            self::$request = $_POST;
        }
    }

    static public function getDataGET($routeGet){
        return 'Esta es la data. la ruta es => '.$routeGet;
    }


    static public function verifyRequest(){
        $routes = Router::$routes[self::$method]; 
        foreach($routes as $route){
            if(self::$uri === $route){
                Request::data($route);
                $callable = Router::$routes[self::$method][1];
                $callable(new self);
                return;
            }
        }
        echo json_encode(array('El metodo no es soportado o la ruta no esta definida'));
        die;
        return;
    }


}

