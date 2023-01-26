<?php



class Auth extends JwtSession{
    private $token = '';
    
    public function set($nameCookie = 'session', $token = null){
        if($token == null){
            $token = server()->getCookies($nameCookie);
        }
        $this->token = $token;
    }

    public function auth($location = 'data'){
        return $this->decodeJwt($this->token)->$location;
    }

}