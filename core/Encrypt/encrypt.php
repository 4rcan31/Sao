<?php 


 class Encrypt{
    protected $keyDefault = '123';

    
    public function encrypt(string $string, string $key){
        $ivlen = openssl_cipher_iv_length("AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt(base64_encode($string), 'AES-128-CBC', $key, OPENSSL_RAW_DATA , $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        return $this->encode(base64_encode($iv.$hmac.$ciphertext_raw), $key.$this->keyDefault);
    }

    private function encode($string, $key){
        $return = null;
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $return .= $char;
        }
        return base64_encode($return);
    }
    //FIN DE encrypt


    //start decrypt
    public function decrypt(string $string, string $key){
        $string = $this->decode($string, $key.$this->keyDefault);
        $c = base64_decode($string);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        if (hash_equals($hmac, $calcmac)){
            return base64_decode($original_plaintext);
        }else{
            return "¿Que intentas?";
        }
    }

    private function decode($string, $key){
        $return = null;
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $return .= $char;
        }
            if(is_numeric($return)) {
                return intval($return);
            } else {
                return $return;
            }
    }
    //end decrypt
} 