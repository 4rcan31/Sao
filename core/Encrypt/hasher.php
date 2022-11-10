<?php 



class Hasher{
    public function hasher($PasswordInTextPlane){
        $r = password_hash(
            base64_encode(
                hash('sha256', $PasswordInTextPlane, true)
            ),
            PASSWORD_DEFAULT
        );
        return $r;
    }

    public function verifyHash($PasswordInTextPlane, $hash){
        $r = password_verify(
            base64_encode(
                hash('sha256', $PasswordInTextPlane, true)
            ),
            $hash
        );
        return $r;
    }
}