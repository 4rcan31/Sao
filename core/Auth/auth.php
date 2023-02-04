<?php

class Auth {
    private static $data = [];

    public static function set(array $data){
        Auth::$data = $data;
    }


    public static function data(){
        return arrayToObject(Auth::$data);
    }


}




