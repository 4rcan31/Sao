<?php 


class Router extends Request{
    static public $routes = [
        'GET' => [], 
        'POST'=> [],
        'PUT' => [], 
        'DELETE' => []
    ]; //pool of routes definidas




    static public function get(){
        self::createPool(func_get_args(), 'GET');
    }
    static public function post(){
        self::createPool(func_get_args(), 'POST');
    }
    static public function put(){
        self::createPool(func_get_args(), 'PUT');
    }
    static public function delete(){
        self::createPool(func_get_args(), 'DELETE');
    }


    static public function createPool($args, $method){
        $callable = array_pop($args); //Funciones
        $routes = array_shift($args); //Rutas
        array_push(self::$routes[$method], $routes, $callable);
       // array_push(self::$callable, $callable);
    }




    static private function mapRoutes(){
        foreach(self::$routes as $method => $routesAndCallables){
           self::$routes[$method] =  array_chunk($routesAndCallables, 2);
        }
    }


    static public function run(){
        Request::verifyRequest();
        Router::mapRoutes();

        //var_dump(self::$routes);
       // echo json_encode(self::$routes);
    }



}





