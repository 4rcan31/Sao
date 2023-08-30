<?php


class Route extends Request{

    //Configuracion de ejecucion
    private static $executed = ''; //Aca se guarda lo ultimo que se ejecuto, ya sea un grupo o una ruta
    private static $lastExecuted = []; //Aca se guarda la ultima cosa ejecutada (lo que paso antes de lo que tenia $executed en ese tiempo del algoritmo)
    private static $typeExecuted = ''; //Aca se guarda el tipo de datos que se ejecuto, ya sea un 'GROUP' o una ruta que puede tener: 'GET' 'POST' etc
    private static $idExecuted = 0; //Aca se guarda el id de lo que se ejecuto, ya sea el id de un grupo o de una ruta


    //Configuracion de rutas
    private static $routes = []; //Aca esta todas las rutas definidas con su configuracion
    private static $idRoute = 0; // Este numero es correlativo y dice el id de las rutas definidas


    //Configuracion de grupos
    private static $idGroup = 0; //Este es un numero correlativo que contiene el id de los grupos
    private static $groups = []; //Contiene temporalmente los grupos de rutas


    private static $err = [];


    //NOTA: Si existen grupos anidados, el agoritmo empieza a contar desde el grupo "mas anidado" hacia afuera

    function __construct($executed, $typeExecuted, $idExecuted){
        Route::$executed = $executed;
        Route::$typeExecuted = $typeExecuted;
        Route::$idExecuted = $idExecuted;
    }

    public static function get(string $route, callable $function){
        Route::addRoute($route, $function, 'GET');
        return new Route($route, 'GET', Route::$idRoute);
    }

    public static function post(string $route, callable $function){
        Route::addRoute($route, $function, 'POST');
        return new Route($route, 'POST', Route::$idRoute);
    }

    public static function put(string $route, callable $function){
        Route::addRoute($route, $function, 'PUT');
        return new Route($route, 'PUT', Route::$idRoute);
    }

    public static function delete(string $route, callable $function){
        Route::addRoute($route, $function, 'DELETE');
        return new Route($route, 'DELETE', Route::$idRoute);
    }

    public static function root(callable $callable, string $method = 'GET'){
        Route::addRoute('/', $callable, $method);
        return new Route('/', $method, Route::$idRoute);
    }

    public function middlewares(Array $middlewares){
        $this->set('middlewares', $middlewares);
        return new Route(Route::$executed, Route::$typeExecuted, Route::$idExecuted);
    }

    public function prefix(string $prefix){
        $this->set('prefix', Route::setUri($prefix));
        return new Route(Route::$executed, Route::$typeExecuted, Route::$idExecuted);
    }

    public static function setUri(string $uri){
        return '/'.trim($uri, '/');
    }

    public static function setIdGroup(){
        Route::$idGroup = Route::$idGroup + 1;
        return Route::$idGroup;
    }

    public static function setIdRoute(){
        Route::$idRoute = Route::$idRoute + 1;
        return Route::$idRoute;
    }

    public static function addRoute(string $route, callable $function, string $method){
        array_push(Route::$routes, [
            'idRoute' => Route::setIdRoute(), 
            'route' => Route::setUri($route),
            'function' => $function,
            'method' => $method,
            'middlewares' => [],
            'prefix' => [],
            'idGroup' => []
        ]); 
    }

    public static function redirec(string $page){
        header("Location: $page");
        exit;
    }



    public static function group(callable $callable){     
        array_push(Route::$lastExecuted, [
            'id' => Route::$idExecuted,
            'type' => Route::$typeExecuted,
            'data' => Route::$executed
        ]);
        $templastIdExecutedBeforeGroup = Route::$idExecuted; // Este es el numero mas chico 
        $callable();
        $lastIdExecutedOfGroup = Route::$idExecuted;//este es el numero mas grande
        $idGroup = Route::setIdGroup();
        for($i = 0; count(Route::$lastExecuted) > $i; $i++){
            if(Route::$lastExecuted[$i]['type'] == 'GROUP'){
               $lastIdExecutedBeforeGroup = Route::$idExecuted - 1; //Tampoco se por que necesito restarle 1 aca
            }else{
                if($templastIdExecutedBeforeGroup ==  Route::$lastExecuted[$i]['id']){
                    $lastIdExecutedBeforeGroup = $templastIdExecutedBeforeGroup;
                    break; //No se si poner un brake aca es necesario
                }else{
                    $lastIdExecutedBeforeGroup = Route::$lastExecuted[$i]['id']; //Puse el brake por si esto pasa, pero no se por que pasaria
                }
            }
        }
        if(Route::$typeExecuted == 'GROUP'){
           $lastIdExecutedOfGroup = Route::$idRoute;
        }
        $diff = [];
        $pass = false;
        for($i = 0;  $lastIdExecutedOfGroup >= $i; $i++){
            if($i == $lastIdExecutedBeforeGroup || $pass){
                $pass = true;
                array_push($diff, $i);
            } // aca creo que puede caber la posibilidad que $lastIdExecutedBeforeGroup sea 0, o sea que no haya una ruta antes del grupo, pero anide todas
            //  Las rutas definidas por el usuario en un grupo por default, y eso creeria que lo soluciona
        }
        for($i = 0; count(Route::$routes) > $i; $i++){
            for($j = 1; count($diff) > $j; $j++){
                if(Route::$routes[$i]['idRoute'] == $diff[$j]){
                    array_push(Route::$routes[$i]['idGroup'],$idGroup); 
                    array_push(Route::$groups, [
                        'idGroup' => $idGroup,
                        'routes' => Route::$routes[$i]
                    ]);
                }
            }
        }
       return new Route(Route::$groups, 'GROUP', $idGroup); 
    }

    public function set(string $type, mixed $data){
        for($i = 0; count(Route::$routes) > $i; $i++){
            if(Route::$typeExecuted == 'GROUP'){
                for($j = 0; count(Route::$routes[$i]['idGroup']) > $j; $j++){
                    if(Route::$routes[$i]['idGroup'][$j] == Route::$idExecuted){
                        array_push(Route::$routes[$i][$type], $data);
                    }
                }
            }else{
                if(Route::$routes[$i]['idRoute'] == Route::$idExecuted){
                    array_push(Route::$routes[$i][$type], $data);
                }
            }
        }
    }

    public static function doPrefix(Array $prefixs){
        $prefix = '';
        for($i = 0; count($prefixs) > $i; $i++){
            $prefix = $prefixs[$i].$prefix;
        }
        return $prefix;
    }

    public static function doMiddlewares(Array $middlewares){
        for($i = 0; count($middlewares) > $i; $i++){
            for($j = 0; count($middlewares[$i]) > $j; $j++){
                $data = explode('@', $middlewares[$i][$j]);
                $file = $data[0]; $function = $data[1];
                $middleware = import("middlewares/$file.php");
                if($middleware->{$function}() === false){
                    res(403);
            }
            }

        }
    }

    public static function error(int $err, callable $callable){
        array_push(Route::$err, [
            'error' => $err,
            'callable' => $callable
        ]);
    }

    public static function run(){
      // prettyPrint(Route::$routes);
        for($i = 0; count(Route::$routes) > $i; $i++){
            $route = Route::$routes[$i]['route'];
            $callback = Route::$routes[$i]['function'];
            $method = Route::$routes[$i]['method'];
            $prefixs = Route::$routes[$i]['prefix'];
            $middlewares = Route::$routes[$i]['middlewares'];
            !empty($prefixs) ? $route = Route::doPrefix($prefixs).$route : null;
            strpos($route, '%') !== false ? $route = preg_replace('/\%\w+/', '(\w+)', $route) : null;
            if(preg_match("@^" . $route . "$@", Request::$uri, $matches)){
                $err = false;
                if($method == Request::$method){
                    !empty($middlewares) ? Route::doMiddlewares($middlewares) : null;
                    array_shift($matches); 
                    if(!empty($matches)){
                        $callback($matches, Request::$data); break;
                    }else{
                        $callback(Request::$data); break;
                    }
                }else{
                    $err = 405;
                }
            }else{
                $err = 404;
            }
        }

        if($err !== false){
            for($i = 0; count(Route::$err) > $i; $i++){
                if(Route::$err[$i]['error'] === $err){
                    Route::$err[$i]['callable']();
                    return;
                }
            }
            res($err);
        }
    } 
}