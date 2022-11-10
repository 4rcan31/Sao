<?php


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


function controller($controller){
    include(dirname(__DIR__, 2).'/app/Controllers/'.$controller);
}

function view($html){
    include(dirname(__DIR__, 2).'/app/Views/'.$html);
}


function import($Modulo, $importRoute = 'local' ){
    if($importRoute == 'local'){
        $rute = dirname(__DIR__, 2).'/core/'.$Modulo;
    }else{
        $rute = $importRoute;
    }

    $files = array_reverse(getFilesByDirectory($rute));
    if(file_exists($rute)){
        foreach($files as $file){
            require_once $rute."/".$file;
        }
        return new $Modulo;
    }else{
        echo 'No module named "'.$Modulo.'"'."\n";
        
    }

}








