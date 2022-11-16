<?php


class Request{
    public static $method;
    public static $uri;


    
    protected $request; //Estos son todos los datos 
    public $path;

    



     public static function capture(){
        
        self::$method = $_SERVER["REQUEST_METHOD"];
        self::$uri = (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        //$this->path = $path;

       // echo 'HOLAAAAAAAAA, SI ME ESTOY EJECUTANDO, NO SE QUE PUERCAS ME PASAAAAAAA<br>';
    }


    public function data(){
        if(self::$method == 'GET'){
            return $this->dataGET('ESTA ES UNA RUTA XD');
        }else{
            return $this->dataMethod();
        }
    }

    public function dataGET($routeDefinida){
        return 'This is the data GET';
    }

    public function dataMethod(){
        return $_POST;
    }

    


   /*  public function request(){
        return self::$request;
    }

    static public function data($route){
        $method = self::$method;
        if($method == 'GET'){
           self::$request = self::getDataGET($route);
        }elseif($method == 'POST'){
            self::$request = $_POST;
        }
    }

    static public function getDataGET($routeGet){
        return 'Esta es la data. la ruta es => '.$routeGet;
    }


    static public function E404(){
        $routes = Router::$routes[self::$method]; 

        $E404 = true;
        foreach($routes as $infoRoute){
            if(in_array(self::$uri, $infoRoute)){
                $E404 = false;
            }
        }

        if($E404){
            echo '404';
            die; return; exit;
        }

    } */

  /*   static public function veryfyMethod(){
        
    } */


}

