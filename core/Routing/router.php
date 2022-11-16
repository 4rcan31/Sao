<?php

class Router extends Request{

    private static $routes = [
        'GET' => [], 
        'POST'=> [],
        'PUT' => [], 
        'DELETE' => []
    ]; //pool of routes definidas

    private static $callables = [
        'GET' => [], 
        'POST'=> [],
        'PUT' => [], 
        'DELETE' => []
    ];


    public static function add($uri, $method, $action = null) {
        array_push(Router::$routes[$method], '/' . trim($uri, '/'));
        if ($action != null) {
            array_push(self::$callables[$method], $action);
        }

    }


     public static function get($uri, $callable){
        self::add($uri, 'GET', $callable);
    }
    public static function post($uri, $callable){
        self::add($uri, 'POST', $callable);
    }

    public static function put($uri, $callable){
        self::add($uri, 'PUT', $callable);
    }

    public static function delete($uri, $callable){
        self::add($uri, 'DELETE', $callable);
    }

    public static function run(){
        $E404 = true;
        $method = Request::$method;

        foreach(self::$routes[$method] as $key => $route){
            if(preg_match('#^'.$route.'$#', self::$uri)){
                $E404 = false;
                $action = self::$callables[self::$method][$key];
                self::runAction($action);
                return;
            }
        }
        $E404 ? view('404', 'core/err/server') : null;

    }

    private static function runAction($action) {
        if($action instanceof \Closure){
            $action(request()->data());
        }else{
            $params = explode('@', $action);
            $obj = new $params[0];
            $obj->{$params[1]}();
        }
    }


}
?>