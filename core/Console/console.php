<?php 

require 'core/Console/app.php';
$console = new SaoConsole;
$argrs = $_SERVER['argv'];
$path = dirname(__DIR__, 2);


/* 
    Las palabras claves son:

    do => [
        migrations
    ]

    execute => [
        migrations
    ]
*/

if(isset($argrs[1]) && $argrs[1] == 'do'){
    if(isset($argrs[2]) && $argrs[2] == 'migration'){
        isset($argrs[3]) ? $console->doMigration($argrs[3]) : print('Tienes que nombrar tu migracion');
    }else{
        print("El comando '".$argrs[2]."' no se reconoce\n");
    }
}else if(isset($argrs[1]) && $argrs[1] == "execute"){
    if(isset($argrs[2]) && $argrs[2] == "migrations"){
        $console->runMigrations();
    }else{
        print("El comando '".$argrs[2]."' no se reconoce\n");
    }
}else{
    print("El comando '".$argrs[1]."' no se reconoce\n");
}
