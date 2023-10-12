<?php


class ViewData{

    static $data;

    public static function setData(Array|object $data){
        $_SESSION['dataview'] = $data;
        return 0;
    }



    public static function get(){
        $return =  $_SESSION['dataview'];
        self::unsetData();
        return $return;
    }


    public static function unsetData(){
        if(isset($_SESSION['dataview'])){
            unset($_SESSION['dataview']);
            return true;
        }
        return false;
    }  
}