<?php 



class Hasher{
    public static function make(string $stringInTextPlane){
        $r = password_hash(
            base64_encode(
                hash('sha256', $stringInTextPlane, true)
            ),
            PASSWORD_DEFAULT
        );
        return $r;
    }

    public static function verify(string $stringInTexPlane, string $hash){
        $r = password_verify(
            base64_encode(
                hash('sha256', $stringInTexPlane, true)
            ),
            $hash
        );
        return $r;
    }


   
}