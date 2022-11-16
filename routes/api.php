<?php








Router::get('/', function($data){ 
   controller('IndexController', 'home', 'table.model', $data);
});


Router::get('/user', function($data){
   controller(
      'IndexController',
      'showUsers', 
      'table.model',
      $data
   );
});








/*  for($i = 0; $i < 100000; $i++){
   $router->add('/ho'.$i,function(){
      echo "Hola Mundo - Esta es una ruta simple";
    });

} */



//$router->route();

//Con 100,000 el router peta (o se tarda mucho xd)

/* Router::get('/', function(Request $response){


   $encrypter = import('Encrypt');
   $console = import('Console');

   echo 'Home';

 
    
   
});


Router::get('/sdsdsd', function(Request $response){


   $encrypter = import('Encrypt');
   $console = import('Console');

   echo 'Home';

 
    
   
});





Router::get('/users', function(){
   echo 'users';
});


 Router::post('/sd', function($data){
   
 });

 Router::post("/users", function(){
    
 });


Router::run(); */


/* for($i = 0; $i < 100000; $i++){
   Router::get('/sdsdsd'.$i, function(){
      echo "Holapxd";
   });
} */