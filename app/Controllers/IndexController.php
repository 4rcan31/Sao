<?php 


class IndexController extends BaseController{
    

    public function home($data){
        view('index');
    }


    public function showUsers($id){
        $id = 12;
        $res = model('exampleModel')->getUserById($id);
        res($res);
    }
}