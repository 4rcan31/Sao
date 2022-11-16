<?php 


class OLDRouter{
    static public $routes = [
        'GET' => [], 
        'POST'=> [],
        'PUT' => [], 
        'DELETE' => []
    ]; //pool of routes definidas




    static public function get(){
        self::createPool(func_get_args(), 'GET');
    }
    static public function post(){
        self::createPool(func_get_args(), 'POST');
    }
    static public function put(){
        self::createPool(func_get_args(), 'PUT');
    }
    static public function delete(){
        self::createPool(func_get_args(), 'DELETE');
    }


    static public function createPool($args, $method){
        $callable = array_pop($args); //Funciones
        $routes = array_shift($args); //Rutas
        $routes[0] != '/' ? $routes = '/'.$routes : $routes = $routes;
        array_push(self::$routes[$method], $routes, $callable);
    }




    static private function mapRoutes(){
        $routes = self::$routes; 
        foreach($routes as $method => $routesAndCallables){
           $routes[$method] =  array_chunk($routesAndCallables, 2, true);
        }

        foreach($routes as $method => $routesAndCallables){
            for($i = 0; count($routesAndCallables) > $i; $i++){
                sort($routesAndCallables[$i]);

                $routes[$method] = $routesAndCallables;
           }
        }
        self::$routes = $routes;
    }


    static public function run(){
      //  Router::mapRoutes();
        //Request::E404();
     //   Request::verifyRequest();
     

        //var_dump(self::$routes);
       // echo json_encode(self::$routes);
    }



}





