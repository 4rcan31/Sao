<?php

function readTxt($name){
    //abrimos el archivo de texto y obtenemos el identificador
    $fichero_texto = fopen ($name, "r");
    //obtenemos de una sola vez todo el contenido del fichero
    //OJO! Debido a filesize(), sólo funcionará con archivos de texto
    $contenido_fichero = fread($fichero_texto, filesize($name));
    return $contenido_fichero;
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

function getDirsFilesByDirectory($dir){
    $return = [];
    for($i = 0; $i < count(getFilesByDirectory($dir)); $i++){
        array_push($return, $dir.getFilesByDirectory($dir)[$i]);
    }
    return $return;
}




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
