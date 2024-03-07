<?php


function controller($controller, $function, $data = 'nulldata'){
    $controller = import('Controllers/'.$controller.'.php');
    if($data == 'nulldata'){
     try{
         return $controller->{$function}();
     }catch(\Throwable $th){
         throw new Exception("Error in Controller: $th");
         return;
     }
    }else{
        return $controller->{$function}($data);
    
    }
 }
 