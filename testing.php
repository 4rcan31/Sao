<?php




function arrayToObject(Array $array){
    return json_decode(json_encode($array, JSON_FORCE_OBJECT));
}

class Auth {
    private static $data = [];

    public static function set(array $data){
        Auth::$data = $data;
    }


    public static function data(){
        return arrayToObject(Auth::$data);
    }


}

Auth::set([
    'id' => 1,
    'user' => 'pepe'
]);

echo Auth::data()->id;










