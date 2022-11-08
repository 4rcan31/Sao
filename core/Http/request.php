<?php


class Request{

    static public function capture(){
        return $_SERVER["REQUEST_METHOD"];
    }

    public function method(){
        return self::capture();
    }
}

