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
    $dir = rtrim($dir, DIRECTORY_SEPARATOR);
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


function copyDirectory($source, $destination) {
    if (!is_dir($destination)) {
        mkdir($destination, 0777, true);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        if ($item->isDir()) {
            mkdir($destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        } else {
            copy($item, $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        }
    }
}

function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return;
    }
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                deleteDirectory($dir . DIRECTORY_SEPARATOR . $file);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $file);
            }
        }
    }
    rmdir($dir);
}
