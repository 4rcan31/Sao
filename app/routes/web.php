<?php

//Si quieres ver la url visitada actualmente puedes ejecutar: Request::$uri;





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





Route::root(function(){
    res("This is the root");
}); 


Route::get('/productos', function(){
    
})->middlewares(['test@test']);









Route::get('/admin/user', function(){

});


Route::get('/admin/staff', function(){

});



Route::group(function(){

    Route::get('/user', function(){

    });
    
    
    Route::get('/staff', function(){ // admin/test/staff
    
    })->middlewares([])->prefix('/test');



})->prefix('/admin')->middlewares([]);





Route::post('/on', function($request){
    require_once '../db.php';


    MemoryDatabase::insert('events', [
        'userName' => $request['username'],
        'idArduino' => $request['arduino'],
        'licenseArduino' => $request['license'],
        'indication' => 'on'
    ]);
});




Route::error(405, function(){
    res(["The method not allowed"]);
});

Route::get('/test', function(){
    view('test');
});