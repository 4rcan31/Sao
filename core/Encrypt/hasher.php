<?php 



class Hasher{
    public static function make($PasswordInTextPlane){
        $r = password_hash(
            base64_encode(
                hash('sha256', $PasswordInTextPlane, true)
            ),
            PASSWORD_DEFAULT
        );
        return $r;
    }

    public static function verify($PasswordInTextPlane, $hash){
        $r = password_verify(
            base64_encode(
                hash('sha256', $PasswordInTextPlane, true)
            ),
            $hash
        );
        return $r;
    }


   
}