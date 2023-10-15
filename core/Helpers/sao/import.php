<?php

function import(string $module, bool $return = true, string $route = '/app', array $data = []){
    $dir = dirname(__DIR__,3).'/'.trim($route, '/').'/'.$module;
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