<?php 


class Routerold extends Request{
    static public $routes = [
        'GET' => [], 
        'POST'=> [],
        'PUT' => [], 
        'DELETE' => []
    ]; //pool of routes definidas


/* 
    static public function get(string $route, $controller){
        $args = func_get_args();
        foreach($args as $v){
            echo $v."<br>";
        }
       // $Data = self::data($route);
        //self::configRoute('GET', $route, $controller);
    } */

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
        array_push(self::$routes[$method], array_shift($args));
    }


    static public function run(){
        Request::verifyRequest();
    }

    static private function configs($method, $route, $controller){
        $a = false;
        if($method != self::$method){
            echo json_encode(array('Method not supported'));
            return;
        }
        self::$routes[$method] = array();
        self::$controllers[$method] = array();
        array_push(self::$routes[$method], $route);
        array_push(self::$controllers[$method], $controller);

        foreach(self::$routes[$method] as $values){
            if($values === self::$uri){
                echo 'Estas en: '.self::$uri;
                $a = true;
            }
        }

        if(self::$uri !== $route){
            echo json_encode(array('La ruta no esta definida!')); 
            return;
        }

        if(!$a){ echo json_encode(array('La ruta no esta definida!')); return;}


    }





}





