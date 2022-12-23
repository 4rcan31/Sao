<?php


class Cookies{
    public function cookie($name, $dato = '', $expirate = 0, $path = '', $domain = '', $secure = false, $httponly = false){
        return setcookie($name, $dato, $expirate, $path, $domain, $secure, $httponly);
    }
}