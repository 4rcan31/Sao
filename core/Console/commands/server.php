<?php

Jenu::command('serve', function($args){
    $route = '-t '.Jenu::baseDir().'/public';
    $serverAddress = '-S 127.0.0.1';
    $port = '8080';
    /* 
        php -S localhost:8080 -t /public
        php jenu /public/test
        php jenu 127.0.0.1:8081 /public/test
        php jeny 127.0.0.1:8081

        El primer argumento siempre se espera que sea la ruta, y el segundo es opcional
        y se espera que sea la dirección IP del servidor.
    */
    if(isset($args[0])){
        $route = '-t '.Jenu::baseDir().$args[0];
    }
    if(isset($args[1])){
        $serverAddress = "-S ".explode(':', $args[1]);
        $port = explode(':', $args[1]);
    }

    exec("php $serverAddress:$port $route");
}, 'Run the development server', 'Sao:Http');