<?php 


class Sao{



    public function doMigration($name){
        $date = date('D.d.M.Y_H.i.s');
        $name = $name."_".$date.".php";
        $file = dirname(__DIR__, 2).'/app/DataBase/migrations/'.$name;
        $file = fopen($file,"w+b");
        if(!$file){
            print('The migration: "'.$name.'" was not created in the rute: '.$file);
            return; 
        }


        // Escribir en el archivo:
        fwrite($file, "<?php\n");
        fwrite($file, "class migration{");
        // Fuerza a que se escriban los datos pendientes en el buffer:
        fflush($file);

        

    // Cerrar el archivo:
        fclose($file);
    }

}