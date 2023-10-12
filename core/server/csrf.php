<?php



class TokenCsrf{
    public static function generateToken() {
        return bin2hex(random_bytes(32)); // Genera un token aleatorio
    }
    
    public static function getTokenFromSession() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = self::generateToken();
        }
        return $_SESSION['csrf_token'];
    }

    public static function token(){
        echo self::getTokenFromSession();
    }

    public static function input(){
        echo self::getInput();
    }

    public static function getInput(){
        return '<input type="hidden" name="csrf_token" value="'.self::getTokenFromSession().'">';
    }
    
    public static function validateToken($request) {
        if(isset($request['csrf_token'])){
            if(isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $request['csrf_token']){
                unset($_SESSION['csrf_token']);
                return true;
            }
        }
        return false;
    }
}