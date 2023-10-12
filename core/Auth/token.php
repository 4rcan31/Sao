<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token {
    private $token;
    public function __construct() {
        $this->token = bin2hex(random_bytes(32));
    }

    public function __toString() {
        return $this->token;
    }

    public function getToken(){
        return $this->token;
    }
    
}


class JsonWebToken {
    protected $token;

    public function __construct(array $payload, $signature, $algoritmo = 'HS256') {
        return $this->token = $this->jwt($payload, $signature, $algoritmo);
    }

    private function jwt(array $payload, $signature, $algoritmo) {
        return JWT::encode(
            $payload,
            $signature,
            $algoritmo
        );
    }
}

class VerifyJsonWebToken{
    protected $payload;

    public function __construct(string $token, string $signature, string $algoritmo = 'HS256') {
        return  $this->verify($token, $signature, $algoritmo);
    }

    public function verify(string $token, $signature, $algoritmo) {
        try {
            $this->payload = JWT::decode($token, new Key($signature, $algoritmo));
            return true;
        } catch (\Throwable $th) {
            return false;
        }
      
    }
}

class getPayLoad extends VerifyJsonWebToken{
    function __construct(string $token, string $signature, string $algoritmo = 'HS256'){
        if($this->verify($token, $signature, $algoritmo)){
            return JWT::decode($token, new Key($signature, $algoritmo));
        }else{
            throw new Exception("El token no es valido");
        }
    }
}
