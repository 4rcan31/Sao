<?php
import('server', false, '/core');
//Files App
//Devuelve un array con todas las carpetas que exiten en $path, en el caso de no haber archivos en esa carpeta devuelve false.


function showFiles($path){
    $dir = opendir($path);
    if(file_exists($path) && $dir){
        $files = array();
        while ($current = readdir($dir)){
            if( $current != "." && $current != "..") {
                if(is_dir($path.$current)) {
                   showFiles($path.$current.'/');
                }else{
                    $files[] = $current;
                }
            }
        }
       if(count($files) > 0){
            return $files;
       }else{
           return false;
       }  
    }else{
        echo "El fichero no existe";
    }
}


function getFilesByDirectory($dir){
    $dirs = array();
    if ($handler = opendir($dir)) {
        while (false !== ($file = readdir($handler))) {
            if($file != "." && $file !== '..'){
                array_push($dirs, $file);
            }
        }
        closedir($handler);
    }
    return $dirs;
}
//End Files App

//Request App

function request(){
    return new Request;
}
//end

//server App

function server(){
    return new Server;
}
//end

function controller($controller, $function, $model = '',  $data =[], $imports = []){
    import('controllers/'.$controller.'.php', false);
    if(!empty($model)){
        import('models/'.$model.'.php', false);
    }
    try {
        if(empty($imports)){
            $controller = new $controller;
        }else{
            $controller = new $controller($imports);
        }
      
        if(empty($data)){
            $controller->{$function}();
        }else{
            $controller->{$function}($data);
        }

        return true;
    } catch (\Throwable $th) {
        return false;
    }    
}




function import($module, $return = true, $route = '/app', $data = []){
    $dir = dirname(__DIR__,2).'/'.trim($route, '/').'/'.$module;
    if(file_exists($dir)){
        if(is_dir($dir)){
            $files = getFilesByDirectory($dir);
            foreach($files as $file){
                require_once $dir.'/'.$file;
            }
        }else if(is_file($dir)){
            require_once  $dir;
            if($return){
                $module = deleteFormat(lastDir($dir));
                return new $module($data);
            }
        }else{
            echo '<br><b>Error: </b> No module named "'.$dir.$module.'"'."\n";
        }
    }else{
        echo '<br><b>Error: </b> No module named "'.$dir.$module.'"'."\n";
    }
}

function core($module, $return = true, $data = []){
    return import($module, $return, '/core', $data);
}

function view($html, $route = '', $format = 'php'){
    try {
        import('Views', false, '/core');
        if(empty($route)){
            import("Views/$html.$format", false);
        }else{
            import("$route/$html.$format", false, '/');
        }
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}

function prettyPrint($array){
    echo '<pre>';
    var_dump($array);
    echo "</pre>";
}


function model($modelName){
    return import('Models/'.$modelName.".php");
}


function res($response, $errorResponseBody = null, $errorResponseHeader = null){
    $res = new Response;
    $res->res($response, $errorResponseBody, $errorResponseHeader);
}

function format($file){
    return  explode(".", $file)[count(explode(".", $file)) - 1];
}

function lastDir($file){
    return  explode("/", $file)[count(explode("/", $file)) - 1];
}

function deleteFormat($file){
    return  explode(".", $file)[count(explode(".", $file)) - 2];
}

function readTxt($name){
    //abrimos el archivo de texto y obtenemos el identificador
    $fichero_texto = fopen ($name, "r");
    //obtenemos de una sola vez todo el contenido del fichero
    //OJO! Debido a filesize(), sólo funcionará con archivos de texto
    $contenido_fichero = fread($fichero_texto, filesize($name));
    return $contenido_fichero;
}

function validate($data){
    return import('validate/validate.php', true, '/core', $data);
}