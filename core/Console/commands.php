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
            
    // Fuerza a que se escriban los datos pendientes en el buffer:
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
    Jenu::print("Welcome to the Sao setup program");
});