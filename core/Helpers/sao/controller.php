<?php


function controller($controller, $function, $data = 'nulldata'){
    $controller = import('controllers/'.$controller.'.php');
    if($data == 'nulldata'){
     try{
         $controller->{$function}();
         return;
     }catch(\Throwable $th){
         throw new Exception('La funcion '.$function." espera parametros que no fueron definidos.");
         return;
     }
    }else{
     $controller->{$function}($data);
     return;
    }
 }
 