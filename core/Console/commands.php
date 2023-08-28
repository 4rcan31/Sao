<?php 


Jenu::command('make:migration', function($argrs){
    $nameMigration = $argrs[0];
    $nameFile = explode(".", $nameMigration)[0]."_".(Jenu::getDate()).".php";
    $file = dirname(__DIR__, 2).'/app/DataBase/migrations/'.$nameFile;
    $file = fopen($file,"w+b");
    if(!$file){ Jenu::error('The migration: "'.$nameFile.'" was not created in the rute: '.$file); return; }
    // Escribir en el archivo:
    $className = explode(".", $nameMigration)[0];        
    $content = <<<EOT
    <?php
    class $className extends Migration {
            
        public function up() {
            \$this->create("$className", function(\$table) {
            
            });
        }
            
        public function down() {
            \$this->dropIfExist("$className");
        }
            
    }
    EOT;
    fwrite($file, $content);
            
    // Fuerza a que se escriban los datos pendientes en  el buffer:
    fflush($file);
    // Cerrar el archivo:
    fclose($file);
    Jenu::success("The migration $nameFile was created successfully");
    return;
});

Jenu::command('execute:migrations', function(){
    $files = getDirsFilesByDirectory(dirname(__DIR__, 2).'/app/DataBase/migrations/');
    for($i = 0; $i < count($files); $i++){
        require_once $files[$i];
        $nameClass = explode("/", explode("_", $files[$i])[0])[count(explode("/", explode("_", $files[$i])[0])) - 1];
        $new = new $nameClass;
        method_exists($new, 'down') ? $new->down() : Jenu::warn("In the migration called '".$nameClass."' dont exist method down");
        method_exists($new, 'up') ? $new->up() : Jenu::warn("In the migration called '".$nameClass."' dont exist method up");
        Jenu::success("The migration '".getFilesByDirectory(dirname(__DIR__, 2).'/app/DataBase/migrations/')[$i]."' was execute");
    }
    return;
});

Jenu::command('migrations:fresh', function(){
    if(!Jenu::condition("Are you sure that delete all the tables? (type YES or NOT)")){ 
        Jenu::warn("The migrations fresh was canceled");
        die;
    }
    $db = new DataBase;
    $tables = $db->query("SELECT GROUP_CONCAT('`', table_name, '`') AS tables
    FROM information_schema.tables
    WHERE table_schema = '".$_ENV['DB_DATABASE']."'")->fetch(PDO::FETCH_ASSOC)['tables'];
    if($tables == null){
        Jenu::warn("There are no tables in the database");
        return;
    }
    $db->query("DROP TABLE IF EXISTS $tables");
    Jenu::execute('execute:migrations');
});

Jenu::command('install', function(){
    Jenu::print('==================================================');
    Jenu::print("======== Welcome to the Sao setup program ========");
    Jenu::print('==================================================');
    Jenu::print("Type the name of the App: ");
    $sep = DIRECTORY_SEPARATOR;
    $nameApp = readline();
    $ruteProject = dirname(Jenu::baseDir()) . $sep . $nameApp . $sep;
    mkdir($ruteProject, 0777);
    copyDirectory(Jenu::baseDir(), $ruteProject);
    foreach(getFilesByDirectory(Jenu::baseDir().$sep."core") as $libsSao){ Jenu::success("Lib '".$libsSao."' was installed"); }
    Jenu::success("Core Sao was installed");
    deleteDirectory($ruteProject.$sep.".git");
    exec("php $ruteProject"."jenu endinstall $nameApp ".Jenu::baseDir(), $output);
    foreach ($output as $line) {
        Jenu::print($line);
    }
    return;
});

Jenu::command('endinstall', function($argrs){
    Jenu::print("In the new project command");
    $nameApp = $argrs[0];
    $dirOldApp = $argrs[1];
    deleteDirectory($dirOldApp);
    Jenu::success("The project '$nameApp' was created correctily");
});

Jenu::command('serve', function($argrs){
    $rute = '-t '.Jenu::baseDir().'/public';
    $serverAdress = '-S localhost';
    $port = '8080';
    /* 
        php -S localhost:8080 -t /public
        php jenu /public/test
        php jenu 127.0.0.1:8081 /public/test
        php jeny 127.0.0.1:8081

        el primer argumento siempre se espera que sea la ruta, y el segundo es opcional
        y se espera que sea la direccion ip del servidor
    */
    if(isset($argrs[0])){
        $rute = '-t '.Jenu::baseDir().$argrs[0];
    }
    if(isset($argrs[1])){
        $serverAdress = "-S ".explode(':', $argrs[1]);
        $port = explode(':', $argrs[1]);
    }

    exec("php $serverAdress:$port $rute");
});