<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Sauth {
    private static $data;
    public static $token = '';

    public static function token(Array $payload, string $key, $encrypter = true, $algori = 'HS256'){
        $jwt = JWT::encode($payload, $key, $algori);
        if($encrypter){
            $jwt = core('Encrypt/encrypt.php')->encrypt($jwt, $key);
        }
        Sauth::$token = $jwt;
        return $jwt;
    }

    public static function decodeToken(string $token, string $key, $encrypter = true, $algori='HS256'){
        if($encrypter){
            $token = core('Encrypt/encrypt.php')->decrypt($token, $key);
        }
        $token  = JWT::decode($token, new Key($key, $algori));
        /* Sauth::$data = $jwt; */
        return $token;
    }


    public static function start(string $token, string $key){
        try{
            $token = Sauth::decodeToken($token, $key);
        }catch(Exception $e){
            $token = false;
        }
        if($token == false){
            return $token;
        }
        Sauth::$data = $token;
        return true;
    }

    public static function data(string $key = ''){
        if(empty($key)){
            return Sauth::$data;
        }
        if(isset(Sauth::$data->$key)){
            return Sauth::$data->$key;
        }else{
            throw new Exception("El indice $key no existe");
        }
    }


}








