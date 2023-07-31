<?php 


class SaoConsole{



    public function doMigration($name){
        $date = date('D.d.M.Y_H.i.s');
        $nameFile = explode(".", $name)[0]."_".$date.".php";
        $file = dirname(__DIR__, 2).'/app/DataBase/migrations/'.$nameFile;
        $file = fopen($file,"w+b");
        if(!$file){
            print('The migration: "'.$nameFile.'" was not created in the rute: '.$file);
            return; 
        }


        // Escribir en el archivo:
        $className = explode(".", $name)[0];        
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
        consoleSuccess("The migration $nameFile was created successfully");
    }


    public function runMigrations(){
        require dirname(__DIR__, 2)."/core/Helpers/sao/import.php";
        require dirname(__DIR__, 2)."/core/DataBase/ORM/orm.php";
        require dirname(__DIR__, 2)."/core/DataBase/Migrations/app.php";
        require dirname(__DIR__, 2)."/core/Helpers/files.php";
        $files = getDirsFilesByDirectory(dirname(__DIR__, 2).'/app/DataBase/migrations/');
        for($i = 0; $i < count($files); $i++){
            require_once $files[$i];
            $nameClass = explode("/", explode("_", $files[$i])[0])[count(explode("/", explode("_", $files[$i])[0])) - 1];
            $new = new $nameClass;
            method_exists($new, 'down') ? $new->down() : consoleWarning("In the migration called '".$nameClass."' dont exist method down");
            method_exists($new, 'up') ? $new->up() : consoleWarning("In the migration called '".$nameClass."' dont exist method up");
            consoleSuccess("La migracion '".getFilesByDirectory(dirname(__DIR__, 2).'/app/DataBase/migrations/')[$i]."' was execute");
        }
    }


}