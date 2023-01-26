<?php 



class exampleModel extends BaseModel{
    

    public function getUserById($id){
        $this->prepare();
        $this->select(['*'])->from('user')->where('id', $id);
        $this->execute()->all();
    }
}
