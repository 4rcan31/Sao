<?php



/* class MemoryDataBase{

    public static $TempData = [];


    
      //  $DataBaseMemoryTempData = [
      //      'tableName' => [ //table 1
      //          'column1name' => [
      //              //rows
      //          ],
      //          'colum2name' => [
      //              //rows
      //          ]
      //      ],
      //      2 => [] //table 2
      //  ]

    public static function createTable(string $name, array $colums){
        MemoryDataBase::$TempData[$name] = []; //Se crea la tabla temporal
        for($i = 0; count($colums) > $i; $i++){
            MemoryDataBase::$TempData[$name][$colums[$i]] = [];
        }
    }

    
      //  $data = [
      //      'columName' => 'dataInsert'
      //  ]

    public static function insert(string $table, array $data){
        foreach(MemoryDataBase::$TempData as $tableName => $tableData){ //Se itererizan todas las tablas
            if($tableName === $table){ //se comprueba la tabla a insertar
                foreach($data as $columInsertName => $columInsertData){ //se itereza todos los datos a insertar
                    foreach($tableData as $columName => $columData){ //se iteriza todos los datos de la tabla
                        if($columInsertName == $columName){
                            array_push(MemoryDataBase::$TempData[$table][$columName], $columInsertData);
                        }
                    }
                }
            }
        }

    }

    public static function selec(string $table, string $colum = null, string $condition = null, mixed $dato = null){
        $datos = [];
        foreach(MemoryDataBase::$TempData as $tableName => $tableData){
            if($tableName == $table){
                if($colum === null){ return $tableData; }
                foreach($tableData as $columName => $columData){
                    if($colum == $columName){
                        if($condition === null){ return $columData; }
                        foreach($columData as $rowData){
                            if(eval("$rowData $condition $dato")){
                                array_push($datos, $rowData);
                            }
                        }
                    }
                }
            }
        }

        return $datos;
    }


    public static function delete(string $table, string $colum = null, string $condition = null, mixed $dato = null){
        foreach(MemoryDataBase::$TempData as $tableName => $tableData){
            if($tableName == $table){
                if($colum === null){ unset(MemoryDataBase::$TempData[$table]); }
                foreach($tableData as $columName => $columData){
                    if($colum == $columName){
                        if($condition === null){ unset(MemoryDataBase::$TempData[$table][$columName]); }
                        foreach($columData as $rowData){
                            if(eval("$rowData $condition $dato")){
                                unset(MemoryDataBase::$TempData[$table][$columName][$rowData]);
                            }
                        }
                    }
                }
            }
        }
    }


    public static function update(string $table, array $data, string $colum = null, string $condition = null, mixed $dato = null){
        MemoryDataBase::delete($table, $colum, $condition, $dato);
        MemoryDataBase::insert($table, $data);
    }


} */



class MemoryDatabase {

    protected static $tables = [];

    public static function createTable(string $name, array $columns) {
        MemoryDatabase::$tables[$name] = array_fill_keys($columns, []);
    }

    public static function allData(){
        return MemoryDatabase::$tables;
    }

    public static function insert(string $table, array $data) {
        if (!isset(MemoryDatabase::$tables[$table])) {
            throw new Exception("Table $table does not exist");
        }
        foreach ($data as $column => $value) {
            if (!array_key_exists($column, MemoryDatabase::$tables[$table])) {
                throw new Exception("Column $column does not exist in table $table");
            }
            MemoryDatabase::$tables[$table][$column][] = $value;
        }
    }

    public static function select(string $table, string $column = null, string $condition = null, $value = null) {
        if(!isset(MemoryDatabase::$tables[$table])) {
            throw new Exception("Table '$table' does not exist");
        }
        $result = [];
        if($column === null) {
            $result = MemoryDatabase::$tables[$table];
        }else if(array_key_exists($column, MemoryDatabase::$tables[$table])) {
            foreach (MemoryDatabase::$tables[$table][$column] as $row) {
                if ($condition === null || eval("return $row $condition $value;")) {
                    $result[] = $row;
                }
            }
        }else{
            throw new Exception("Column $column does not exist in table $table");
        }
        return $result;
    }

    public static function delete(string $table, string $column = null, string $condition = null, $value = null) {
        if (!isset(MemoryDatabase::$tables[$table])) {
            throw new Exception("Table $table does not exist");
        }
        if ($column === null) {
            MemoryDatabase::$tables[$table] = array_fill_keys(array_keys(MemoryDatabase::$tables[$table]), []);
        } elseif (array_key_exists($column, MemoryDatabase::$tables[$table])) {
            foreach (MemoryDatabase::$tables[$table][$column] as $index => $row) {
                if ($condition === null || eval("return $row $condition $value;")) {
                    unset(MemoryDatabase::$tables[$table][$column][$index]);
                }
            }
        } else {
            throw new Exception("Column $column does not exist in table $table");
        }
    }

    public static function update(string $table, array $data, string $column = null, string $condition = null, $value = null) {
        if (!isset(MemoryDatabase::$tables[$table])) {
            throw new Exception("Table $table does not exist");
        }
        MemoryDatabase::delete($table, $column, $condition, $value);
        MemoryDatabase::insert($table, $data);
    }


    public static function listening(){
        while(true){
            
        }
    }

}



