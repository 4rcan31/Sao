<?php 



class exampleModel extends BaseModel{
    

    public function getUserById($id){
        $this->select('users');
        return $this->runSQL();
    }
}
