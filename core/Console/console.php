<?php 

require 'core/Console/app.php';
$console = new Sao;
$argrs = $_SERVER['argv'];
$path = dirname(__DIR__, 2);




if(isset($argrs[1]) && $argrs[1] == 'do'){
    if(isset($argrs[2]) && $argrs[2] == 'migration'){
        if(isset($argrs[3])){
           $console->doMigration($argrs[3]);
        }else{
            print('Tienes que ponerle nombre a tu migracion');
        }
    }
}