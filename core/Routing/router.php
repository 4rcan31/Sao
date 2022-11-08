<?php 


class Router{
    public function test(){
        $methos = new Request;
        return $methos->method();
    }  
}



$t = new Router;


//echo $t->test();

