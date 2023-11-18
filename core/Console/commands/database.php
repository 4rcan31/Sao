<?php

Jenu::command('make:migration', function(){
    $nameMigration = Jenu::get(0, "Fill in the name of the migration");
    $nameFile = explode(".", $nameMigration)[0]."_".(Jenu::getDate()).".php";
    $filePath = Jenu::baseDir("/app/Database/migrations/$nameFile");
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
    file_put_contents($filePath, $content) !== false ?
    Jenu::success("The migration $nameFile was created successfully") : 
    Jenu::error('The migration "'.$nameFile.'" was not created in the route: '.$filePath); 
    return;
}, 'Create a new migration file', 'Sao:Data Base');



Jenu::command('execute:migrations', function(){
    if (!empty((new Database)->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN))) {
        Jenu::warn("Your database has pre-installed tables, executing migrations:fresh");
        Jenu::execute('migrations:fresh');
        return;
    }
    
    $database = new Database();
    try {
        $database->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
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
                        if (method_exists($migrationInstance, 'down')) {
                            $migrationInstance->down();
                        } else {
                            Jenu::warn("In the migration called '".$class."' the 'down' method doesn't exist");
                        }
                        if (method_exists($migrationInstance, 'up')) {
                            $migrationInstance->up();
                        } else {
                            Jenu::warn("In the migration called '".$class."' the 'up' method doesn't exist");
                        }

                        Jenu::success("The migration '".basename($file)."' was executed");
                    }
                }
            }
        }
    } finally {
        $database->query("SET GLOBAL FOREIGN_KEY_CHECKS=1");
    }
}, 'Install Tables to the Database', 'Sao:Data Base');


Jenu::command('migrations:fresh', function(){
    if (!Jenu::condition("Are you sure you want to delete all tables? (Type YES or NO)")) { 
        Jenu::warn("The 'migrations:fresh' operation was canceled");
        return;
    }

    $db = new Database;
    try{
        $db->query("SET GLOBAL FOREIGN_KEY_CHECKS=0");
        $db->query("SET FOREIGN_KEY_CHECKS=0");
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
    } finally {
        $db->query("SET GLOBAL FOREIGN_KEY_CHECKS=1");
        $db->query("SET FOREIGN_KEY_CHECKS=1");
    }
}, 'Reinstall the database', 'Sao:Data Base');




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

Jenu::command('check:connection:mysql', function(){
    try {
        $db = new Database;
        $db->query('SHOW DATABASES');
        Jenu::success("The database connection is successful to ". $db->nameDataBase());
    } catch (\PDOException $e) {
        Jenu::error("Database error: " . $e->getMessage());
    } catch (\Throwable $th) {
        Jenu::error("An unexpected error occurred: " . $th->getMessage());
    }
}, 'Check MySQL database connection', 'Sao:Data Base');


Jenu::command('backup:database', function(){
    $return = '';
    $database = new DataBase;
    $namedb = $database->nameDataBase();
    $tables = $database->query('SHOW TABLES')->fetchAll();

    foreach ($tables as $tableInfo) {
        $tableName = $tableInfo["Tables_in_$namedb"];

        // Obtener la estructura de la tabla
        $schemaResult = $database->query("SHOW CREATE TABLE $tableName")->fetch();
        $return .= "DROP TABLE IF EXISTS `$tableName`;\n";
        if (!empty($schemaResult)) {
            $schema = $schemaResult[1] . ";\n\n";
            $return .= $schema;
        }

        // Obtener los datos de la tabla
        $dataResult = $database->query("SELECT * FROM $tableName")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($dataResult)) {
            $return .= "-- Datos de la tabla $tableName:\n";
            foreach ($dataResult as $row) {
                $return .= "INSERT INTO $tableName (`" . implode('`, `', array_keys($row)) . "`) VALUES ('" . implode("', '", $row) . "');\n";
            }
            $return .= "\n";
        }
    }
    
    $filePath = Jenu::baseDir("/app/Database/export_".Jenu::getDate().".sql");
    file_put_contents($filePath, $return) !== false ?
    Jenu::success("El archivo SQL se ha exportado correctamente a $filePath") : 
    Jenu::error("Error al exportar el archivo SQL.");    
}, "Obtener todas las consultas de la base de datos", 'Sao:Base de datos');


Jenu::command('upload:database', function(){
    $dumpName = Jenu::get(0, "Fill the name dump that you want upload");
    $dir = Jenu::get(1, null, "app/Database/");
    $filePath = Jenu::baseDir("/".$dir) . $dumpName;

    if (!file_exists($filePath)) {
        Jenu::error("File not found: $filePath");
        return;
    }

    $sqlContent = file_get_contents($filePath);

    try {
        $database = new DataBase;
        $pdo = $database->pdo();

        // Ejecuta las consultas SQL sin iniciar explícitamente una transacción
        $pdo->exec($sqlContent);

        Jenu::success("Database file '$dumpName' uploaded successfully.");
    } catch (PDOException $e) {
        Jenu::error("Error connecting or executing SQL queries: " . $e->getMessage());
    }
});


