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
    
    
    
}