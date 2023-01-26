<?php

//Si quieres ver la url visitada actualmente puedes ejecutar: Request::$uri;

Route::get('/', function(){
    echo "This is the root";
});



Route::get('/home', function(){
    controller('IndexController', 'home');
});



Route::group(function(){
    Route::get('/', function(){
        echo "This is the root from group with prefix /public";
    });
    
    
    
    Route::get('home', function(){
        echo "This is the /home from group with prefix /public";
        controller('IndexController', 'home');
    });
    
})->prefix('/public');