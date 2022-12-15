<?php
import('server', false);
//Files App
//Devuelve un array con todas las carpetas que exiten en $path, en el caso de no haber archivos en esa carpeta devuelve false.

use function PHPSTORM_META\type;

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



//Encrypt start
function Encrypt(){
    return new Encrypt;
}

function Hasher(){
    return new Hasher;
}

//end

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
    include(dirname(__DIR__, 2).'/app/Controllers/'.$controller.".php");
    if(!empty($model)){
        include(dirname(__DIR__, 2).'/app/Models/'.$model.".php");
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







function import($Modulo, $return = true, $importRoute = 'local' ){
    if($importRoute == 'local'){
        $rute = dirname(__DIR__, 2).'/core/'.$Modulo;
    }else{
        $rute = $importRoute;
    }

    $files = getFilesByDirectory($rute);
    if(file_exists($rute)){
        foreach($files as $file){
            require_once $rute."/".$file;
        }
        if($return){
            return new $Modulo;
        }
    }else{
        echo '<br><b>Error: </b> No module named "'.$Modulo.'"'."\n";
        
    }

}

function view($html, $route = '', $format = 'php'){
    try {
        import('Views', false);
        if(empty($route)){
            include(dirname(__DIR__, 2).'/app/Views/'.$html.'.'.$format);
        }else{
            include(dirname(__DIR__, 2).'/'.$route.'/'.$html.".".$format);
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


function model($nameClass){
    return new $nameClass;
}


function res($response, $errorResponseBody = null, $errorResponseHeader = null){
    $res = new Response;
    $res->res($response, $errorResponseBody, $errorResponseHeader);
}

function format($file){
    return  explode(".", $file)[count(explode(".", $file)) - 1];
}

function readTxt($name){
    //abrimos el archivo de texto y obtenemos el identificador
    $fichero_texto = fopen ($name, "r");
    //obtenemos de una sola vez todo el contenido del fichero
    //OJO! Debido a filesize(), sólo funcionará con archivos de texto
    $contenido_fichero = fread($fichero_texto, filesize($name));
    return $contenido_fichero;
}