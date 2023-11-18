<?php
import('DataBase/connection.php', false, '/core');


class DataBase extends Connection{
    public $query = '';
    public $data = [];
    public $responseSQL;
    public $judgmentExecuted;
    public $querys = [];



    public function connection(){
        return $this->connection;
    }

    public function prepare(){
        $this->query = '';
        $this->data = [];
    }

    public function nameDataBase(){
        return $this->query('SELECT DATABASE() AS dbname')->fetch()['dbname'];
    }

    public function select($colums = [], $all = true){
        empty($colums) ?  $query = 'SELECT ' : $query = 'SELECT '.implode(',', $colums);
        $this->query = $this->query." ".$query;
        return $this;
    } 

    public function join(string $table){
        $this->query = $this->query." JOIN ".$table;
        return $this;
    }

    public function inner(){
        $this->query = $this->query." INNER ";
        return $this;
    }

    public function left(){
        $this->query = $this->query." LEFT ";
        return $this;
    }

    public function right(){
        $this->query = $this->query." RIGHT ";
        return $this;
    }

    public function full(){
        $this->query = $this->query." FULL ";
        return $this;
    }

    public function on($field1, $field2, $condition = '='){
        $this->query = $this->query." ON $field1 $condition $field2";
        return $this;
    }

    public function from($table){
        $query = ' FROM '.$table;
        $this->query = $this->query.$query;
        return $this;
    }

    public function orderBy($query){
        $this->query = $this->query.' ORDER BY '.$query;
        return $this;
    }

    public function where($colum, $field, $condition = '='){
        $query = ' WHERE '.$colum." ".$condition." ?";
        array_push($this->data, $field);
        $this->query = $this->query.$query;
        return $this;
    }
    public function and($colum, $field, $condition = "="){
        $this->condition('AND', $colum, $field, $condition);
        return $this;
    }
    public function or($colum, $field, $condition = "="){
        $this->condition('OR', $colum, $field, $condition);
        return $this;
    }

    public function not($colum, $field, $condition = "="){
        $this->condition('NOT', $colum, $field, $condition);
        return $this;
    }

    public function condition($sqlCondition, $colum, $field, $condition = "="){
        $this->query = $this->query." $sqlCondition ".$colum.$condition." ?";
        array_push($this->data, $field);
    }

    public function insert(String $table){
        $this->query = $this->query." INSERT INTO ".$table;
        return $this;
    }

    public function values(Array $datos = []){
        if(empty($datos)){
            throw new Exception('You have not specified the data.');
            return false;
        }
        $columsInsert = []; $p = '';
        foreach($datos as $colums => $values){
            array_push($this->data, $values);
            array_push($columsInsert, $colums);
            $p = $p . "?, ";
        }
        $query = "(".implode(', ', $columsInsert).") VALUES (".trim(trim($p), ',').")";
        $this->query = $this->query.$query;
    }

    public function whereIn(string $colum, array $values) {
        if (empty($values)) {
            throw new Exception('You have not specified any values for the IN clause.');
        }
    
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
    
        $this->query .= "WHERE $colum IN ($placeholders)";
        $this->data = array_merge($this->data, $values);
    }
    

    public function count($colums = []){
        if(empty($colums)){
            $query = ' COUNT(*)';
        }else{
            if(is_array($colums)){
                $query = 'COUNT('.implode(', ', $colums).')';
            }else{
                $query = 'COUNT('.$colums.')';
            }
        }
        $this->query = $this->query.$query;
        return $this;
    }



    public function update(string $table, array $data = []){
        if (empty($data)) {
            throw new Exception('You have not specified the data.');
            return false;
        }
    
        $query = "UPDATE {$table} SET ";
        $updateData = [];
        
        foreach ($data as $column => $value) {
            array_push($this->data, $value);
            $updateData[] = "{$column} = ?";
        }
        
        $query .= implode(', ', $updateData);
        $this->query = $query;
        
        return $this;
    }
    
    public function delete(String $table){
        $query = ' DELETE FROM '.$table;
        $this->query = $this->query.$query;
        return $this;
    }

    public function queryString(){
        return [
            'queryStrig' => $this->query,
            'data' => $this->data
        ];
    }
    public function getQuerys(){
        return $this->querys;
    }

    //Esta funcion es la que ejecuta una query
    public function query(String $query, $data = []){
        array_push($this->querys, $this->queryString());
        return $this->executeSql($query, $data);
    }

    public function executeSql(String $query, $data){
        $responseSQL = $this->connection()->prepare($query);
        if($responseSQL){
            if($responseSQL->execute($data)){
                return $responseSQL;
            }else{
                throw New Exception("Unable to do execute statement: " . $query." and the data: ". json_encode($data));
                return false;
            }
        }else{
            throw New Exception("Unable to do prepared statement: " . $query);
            return false;
        }
    }


    public function execute(){
        try{
        $this->responseSQL = $this->query($this->query, $this->data);
        return $this;
        }catch (\Throwable $th) {
            echo "hubo un error";
            echo $th;
        }
    }

    public function all($type = 'fetch'){
        if($type == 'fetch'){

            $response = $this->responseSQL->fetch(PDO::FETCH_ASSOC);
            return is_array($response) ?
            arrayToObject($response) :  
            $response;
        }else if($type == 'fetchAll'){
            $response = $this->responseSQL->fetchAll(PDO::FETCH_ASSOC);
            return is_array($response) ?
            arrayToObject($response) :  
            $response;
        }
    }


    public function fetchColumn(){
        return $this->responseSQL->fetchColumn();
    }

    public function first(){
        return $this->responseSQL->first();
    }

    public function pdo(){
        return $this->connection;
    }

    public function exists() {
        return $this->all() !== false;
    }
    

    public function lastId(){
        return $this->connection()->lastInsertId(); //No entiendo muy bien por que esta funcion nesesita la conexion y no la respuesta sql como las demas funciones
    }
}