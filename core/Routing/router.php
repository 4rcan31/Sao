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
    private static $groups = [
        'GET' => [], 
        'POST'=> [],
        'PUT' => [], 
        'DELETE' => []
    ];


    public static function add($uri, $method, $action = null) {
        array_push(Router::$routes[$method], self::url($uri));
        if ($action != null) {
            array_push(self::$callables[$method], $action);
        }

    }

    public static function url($url){
        return '/'.trim($url, '/');
    }

    public static function get($uri, $callable){
        self::add($uri, 'GET', $callable);
        return [$uri, $callable, 'GET'];
    }
    public static function post($uri, $callable){
        self::add($uri, 'POST', $callable);
        return [$uri, $callable, 'POST'];
    }

    public static function put($uri, $callable){
        self::add($uri, 'PUT', $callable);
        return $uri;
    }

    public static function delete($uri, $callable){
        self::add($uri, 'DELETE', $callable);
        return $uri;
    }

    public static function run(){
        $E404 = true; $method = Request::$method;
        foreach(sortIndex(self::$routes[$method]) as $key => $route){
            if(preg_match('#^'.$route.'$#', self::$uri)){
                $E404 = false;
                $action = sortIndex(self::$callables[self::$method])[$key];
                self::action($action, request()->data());
                return;
            }
        }
        $E404 ? view('404', 'core/err/server') : null;
    }

    private static function action($action, $data = '') {
        if($action instanceof \Closure){
            $action($data);
        }
    }



    static public function prefix($prefix){
       foreach(self::$groups[Request::$method] as $group){
            foreach(self::$routes[self::$method] as $key => $route){
                if($group[0] == $route){
                    unset(self::$routes[self::$method][$key]);
                    array_push(self::$routes[self::$method], self::url($prefix).$route);
                }
            }
       }
       return new self;
    }

    static public function group($routes){
        foreach($routes as $route){
            array_push(Router::$groups[$route[2]], $route);
        }
        return new self;
    }



    public function middlewares($middlewares){
            foreach(sortIndex(self::$routes[Request::$method]) as $route){
                if(preg_match('#^'.$route.'$#', self::$uri)){
                    if(is_array($middlewares)){
                        foreach($middlewares as $middleware){
                            $this->verifyMiddlewares($middleware);
                        }
                    }else{
                        $this->verifyMiddlewares($middlewares);
                    }

                }
            }
    }

    public function verifyMiddlewares($middleware){
        $data = explode('@', $middleware);
        $middle = import('middlewares/'.$data[0].'.php');
        if(!$middle->{$data[1]}()){
            res(['err' => 'acceso denegado'], 401);
            unset(self::$routes); unset(self::$callables); unset(self::$groups);
            die;
        }
    }

    static public function middleware($route, $middlewares = []){
        $route = $route[1];
        if(preg_match('#^'.$route.'$#', self::$uri)){
            foreach($middlewares as $middleware){
                $data = explode('@', $middleware);
                $middle = import('middlewares/'.$data[0].'.php');
                if(!$middle->{$data[1]}()){
                    res(['err'=>'acceso denegado'], 401);
                die;
                }
            }
        }
    }
    
}
?>