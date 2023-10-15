<?php 


class BaseController{

    public function validateCsrfTokenWithRedirection($request, $redirectTo){
        csrf();
        if (!TokenCsrf::validateToken($request)) {
            Form::send($redirectTo, ['Su sesión ha expirado'], 'Error');
        }
        return;
    }

    public function validateFieldsWithRedirection(Array $errors, $redirectTo, $validator){
        if(!$validator->validate()){
            Form::send($redirectTo, $errors, 'Error');
        }
        return;
    }

    public function host(){
        return $_ENV['APP_SERVER_CROQUETTE_HOST'].":".$_ENV['APP_SERVER_CROQUETTE_PORT'];
    }


    public function clientAuth($cookie = 'session', $key = null) {
        $cookie = Request::$cookies[$cookie] ?? null;
        if ($cookie === null) {
            return false;
        }
        return Sauth::getPayLoadTokenClient(
            $cookie, 
            $key ?? $_ENV['APP_KEY']
        );
    }
    
    
    
}