<?php


class Middlewares{
    static public function middleware($route, $middlewares = []){
        $access = true;
        foreach($middlewares as $middleware){
            var_dump($middleware);
            if($middleware == false){
                $access = false;
                break;
            }
        }
        if($access){
            if($route instanceof \Closure){
                $route();
            }
        }else{
            res('Acceso denegado');
            die;
        }
    }
}