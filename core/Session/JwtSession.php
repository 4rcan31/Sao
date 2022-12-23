<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;



class JwtSession{
    public function token(Array $payload = [], $encrypter = true, $algori = 'HS256'){
        $key = $_ENV['KEY'];
        $jwt = JWT::encode($payload, $key, $algori);
        if($encrypter){
            $encrypter = core('Encrypt/encrypt.php');
            $jwt = $encrypter->encrypt($jwt, $key);
        }
        return $jwt;
    }
    public function decodeJwt($jwt, $encrypter = true, $algori='HS256'){
        $key = $_ENV['KEY'];
        if($encrypter){
            $encrypter = core('Encrypt/encrypt.php');
            $jwt = $encrypter->decrypt($jwt, $key);
        }
        $jwt  = JWT::decode($jwt, new Key($key, $algori));
       return $jwt;
    }
}
