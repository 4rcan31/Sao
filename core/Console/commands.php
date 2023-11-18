<?php

Jenu::command('make:migration', function(){
    $nameMigration = Jenu::get(0, "Fill in the name of the migration");
    $nameFile = explode(".", $nameMigration)[0]."_".(Jenu::getDate()).".php";
    $file = dirname(__DIR__, 2).'/app/Database/migrations/'.$nameFile;
    $file = fopen($file, "w+b");
    if (!$file) { 
        Jenu::error('The migration "'.$nameFile.'" was not created in the route: '.$file); 
        return; 
    }
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
            
    // Forzar la escritura de los datos pendientes en el búfer:
    fflush($file);
    // Cerrar el archivo:
    fclose($file);
    Jenu::success("The migration $nameFile was created successfully");
    return;
}, 'Create a new migration file', 'Sao:Data Base');



Jenu::command('execute:migrations', function(){
    if (!empty((new Database)->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN))) {
        Jenu::warn("Your database has pre-installed tables, executing migrations:fresh");
        Jenu::execute('migrations:fresh');
        return;
    }
    
    $alreadyExecutedClasses = [];
    $migrationFiles = getDirsFilesByDirectory(Jenu::baseDir().'/app/Database/migrations/');
    foreach ($migrationFiles as $file) {
        require_once $file;
        $declaredClasses = get_declared_classes();
        foreach ($declaredClasses as $class) {
            if (method_exists($class, 'up') && is_subclass_of($class, 'Migration')) {
                if (!in_array($class, $alreadyExecutedClasses)) {
                    array_push($alreadyExecutedClasses, $class);
                    $migrationInstance = new $class();
                    method_exists($migrationInstance, 'down') ? 
                    $migrationInstance->down() : Jenu::warn("In the migration called '".$class."' the 'down' method doesn't exist");
                    method_exists($migrationInstance, 'up') ? 
                    $migrationInstance->up() : Jenu::warn("In the migration called '".$class."' the 'up' method doesn't exist");
                    Jenu::success("The migration '".basename($file)."' was executed");
                }
            }
        }
    }
}, 'Install Tables to the Database', 'Sao:Data Base');

Jenu::command('drop:tables', function(){
    $db = new Database;
    $tablesQuery = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    if(empty($tablesQuery)){ Jenu::error("The database does not have tables");}
    $confirmation = Jenu::condition("Are you sure you want to delete all tables from the database? (type YES or NO)");
    if ($confirmation) {
        Jenu::print("Waiting for 5 seconds. To cancel, press CTRL+C.");
        sleep(5);
        $dbName = $db->nameDataBase();
        foreach ($tablesQuery as $table) {
            $db->query("DROP TABLE IF EXISTS `$table`");
            Jenu::warn("Table '$table' has been dropped.");
        }
        Jenu::warn("All tables have been deleted from the '$dbName' database.");
    } else {
        Jenu::warn("Operation aborted.");
    }
}, 'Drop all tables to the DataBase', 'Sao:Data Base');


Jenu::command('migrations:fresh', function(){
    if (!Jenu::condition("Are you sure you want to delete all tables? (Type YES or NO)")) { 
        Jenu::warn("The 'migrations:fresh' operation was canceled");
        return;
    }

    $db = new Database;
    $tablesQuery = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tablesQuery)) {
        Jenu::warn("There are no tables in the database");
    } else {
        foreach ($tablesQuery as $table) {
            $db->query("DROP TABLE IF EXISTS `$table`");
            Jenu::warn("Table '$table' has been dropped.");
        }
    }

    Jenu::execute('execute:migrations');
}, 'Reinstall the database', 'Sao:Data Base');



Jenu::command('serve', function($args){
    $route = '-t '.Jenu::baseDir().'/public';
    $serverAddress = '-S 127.0.0.1';
    $port = '8080';
    /* 
        php -S localhost:8080 -t /public
        php jenu /public/test
        php jenu 127.0.0.1:8081 /public/test
        php jeny 127.0.0.1:8081

        El primer argumento siempre se espera que sea la ruta, y el segundo es opcional
        y se espera que sea la dirección IP del servidor.
    */
    if(isset($args[0])){
        $route = '-t '.Jenu::baseDir().$args[0];
    }
    if(isset($args[1])){
        $serverAddress = "-S ".explode(':', $args[1]);
        $port = explode(':', $args[1]);
    }

    exec("php $serverAddress:$port $route");
}, 'Run the development server', 'Sao:Http');


Jenu::command('check:connection:mysql', function(){
    try {
        $db = new Database;
        $db->query('SHOW DATABASES');
        Jenu::success("The database connection is successful");
    } catch (\PDOException $e) {
        Jenu::error("Database error: " . $e->getMessage());
    } catch (\Throwable $th) {
        Jenu::error("An unexpected error occurred: " . $th->getMessage());
    }
}, 'Check MySQL database connection', 'Sao:Data Base');



Jenu::command('make:token', function($args){
    isset($args[0]) ?  Jenu::success("The generated token is: ".bin2hex(random_bytes($args[0]))) :
                           Jenu::success("The generated token is: ".bin2hex(random_bytes(32)));
}, 'Generate tokens string', 'Sao:String');


Jenu::command('backup:database', function(){
    $return = '';
    $database = new DataBase;
    $namedb = $database->nameDataBase();
    $tables = $database->query('SHOW TABLES')->fetchAll();
    
    foreach ($tables as $tableInfo) {
        $tableName = $tableInfo["Tables_in_$namedb"];
        
        // Obtener la estructura de la tabla
        $schemaResult = $database->query("SHOW CREATE TABLE $tableName")->fetch();
        if (!empty($schemaResult)) {
            $schema = $schemaResult[1] . ";\n\n";
            $return .= $schema;
        }
        
        // Obtener los datos de la tabla
        $dataResult = $database->query("SELECT * FROM $tableName")->fetchAll();
        if (!empty($dataResult)) {
            $return .= "-- Datos de la tabla $tableName:\n";
            foreach ($dataResult as $row) {
                $return .= "INSERT INTO $tableName (";
                $values = array();
                foreach ($row as $key => $value) {
                    $return .= "`$key`, ";
                    $values[] = "'$value'";
                }
                $return = rtrim($return, ', ');
                $return .= ") VALUES (" . implode(', ', $values) . ");\n";
            }
            $return .= "\n";
        }
    }
    
    echo $return;
    
}, "Get all query of install Data Base", 'Sao:Data Base');



Jenu::command('help', function(){
    $apps = [];
    $others = [];

    foreach (Jenu::$commands as $command) {
        $parts = explode(":", $command['type']);
        
        if (count($parts) === 2) {
            list($type, $group) = $parts;

            // Agrupar comandos por tipo y grupo
            if (!isset($apps[$type][$group])) {
                $apps[$type][$group] = [];
            }

            $apps[$type][$group][] = [
                'command' => $command['command'],
                'message' => $command['help']
            ];
        } else {
            // Comandos que no siguen el formato type:group
            $others[] = [
                'command' => $command['command'],
                'message' => $command['help']
            ];
        }
    }

    // Imprimir comandos en el formato deseado

    foreach ($apps as $type => $groups) {
        Jenu::warn("\n$type:", false);
        foreach ($groups as $group => $commands) {
            foreach ($commands as $cmd) {
                printf("\033[32m%-30s %-15s %s\033[0m\n", $cmd['command'], "(".$group.")", $cmd['message']);
            }
        }
    }

    // Imprimir comandos "Otros"
    if(!empty($others)){
        Jenu::warn("\nOtros:", false);
        foreach ($others as $other) {
            printf("\033[32m%-30s %-15s %s\033[0m\n", $other['command'], "", $other['message']);
        }
        print("\n");
    }


}, "Help command", 'Sao:Help');

