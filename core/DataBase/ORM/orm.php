<?php
require_once dirname(__DIR__, 3).'/core/DataBase/connection.php';


class ORM extends Connection{
    public $query = [
        'select' => '',
        'where'=> '',
        'orderBy' => '',
        'limit' => ''
    ];

    public $data = [
        'table' => '',
        'method' => '',
        'params' => '',
        'colum' => '',
        'condition' => '',
        'campo' => '',
        'limit' => ''
    ];

    public function select($table, $params = []){
        $SQL = null;
        if(count($params) == 0){
            $SQL = 'SELECT * FROM '.$table;
        }else{
            $SQL = "SELECT ".implode(", ",$params)." FROM ".$table;
            $this->data['params'] = $params;
        }
        $this->query['select'] = $this->query['select'].$SQL;
        $this->data['table'] = $table;
        return $this;
    }
    public function orderBy($method = "ASC"){
        $this->query['orderBy'] = $this->query['orderBy']." ORDER BY '$method'";
        $this->data['method'] = $method;
        return $this;
    }
  
  public function where($colum, $condition, $campo){
      $SQL = " WHERE $colum $condition ?";
      $this->query['where'] = $this->query['where'].$SQL;
      $this->data['colum'] = $colum;
      $this->data['condition'] = $condition;
      $this->data['campo'] = $campo;
      
    return $this;
  }

  public function limit($limit = 1000){
        $SQL = " LIMIT $limit";
        $this->query['limit'] = $this->data['limit'].$SQL;
        $this->data['limit'] = $limit;
  }

    public function constructor(){
        $appsql = new $this;
        $appsql->select($this->data['table']);
        $appsql->orderBy($this->data['method']);
        $appsql->where($this->data['colum'], $this->data['condition'], $this->data['campo']);
        $appsql->limit($this->data['limit']);
        $this->query = implode($this->query);
    }

    public function execute($query, $data = []){
        $res = $this->connection->prepare($query);
        if($res){
                 if($res->execute($data)){
                    return $res;
                 }else{
                    throw New Exception("Unable to do execute statement: " . $query." and the data: ". json_encode($data));
                 }
            
        }else{
            throw New Exception("Unable to do prepared statement: " . $query);
        }
    }

    public function query($query, $data = []){
      return $this->execute($query, $data);  
    }

    public function runSQL(){
        
        if($this->query['select'] != ''){
            $this->constructor();
            if($this->data['campo'] != ''){
                $return = $this->execute($this->query, [$this->data['campo']])->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $return = $this->execute($this->query)->fetchAll(PDO::FETCH_ASSOC);
            }
           
        }
        return $return;
    }


}