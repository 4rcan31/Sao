<?php 


class BaseController{

    public function validateCsrfTokenWithRedirection($request, $redirectTo){
        csrf();
        if (!TokenCsrf::validateToken($request)) {
            Form::send($redirectTo, ['Su sesión ha expirado'], 'Error');
            exit;
        }
    }

    public function validateFieldsWithRedirection(Array $errors, $redirectTo, $validator){
        Form();
        if(!$validator->validate()){
            Form::send($redirectTo, $errors, 'Error');
            exit;
        }
    }

    public function validateRequiredFieldsRuleWithRedirection(array $data, array $fields, string $redirectTo, array $errorMessages) {
        $validator = validate($data);
        $validator->rule('required', $fields);
    
        if (!$validator->validate()) {
            Form();
            Form::send($redirectTo, $errorMessages, 'Notice');
        }
        return $validator;
    }

    public function setFileAndHostWithRedirectionAndUpload(array $file, string $redirectTo, string $address = null, string $port = null){
        Form();
        if(!File::setFile($file)){
            Form::send($redirectTo, ['El archivo no se pudo subir correctamente'], 'Error');
        }

        File::setHost(serve(
            ($address === null ? $_ENV['APP_ADDRESS'] : $address) 
            . ":" . 
            ($port === null ? $_ENV['APP_PORT'] : $port)
        ));

        return File::upload() ? 
        File::lastFileUploadInfo('rute:upload') : 
        Form::send($redirectTo, ['El archivo no pudo ser subido'], 'Error');
        
    }
    

    public function host(){
        return $_ENV['APP_SERVER_CROQUETTE_HOST'].":".$_ENV['APP_SERVER_CROQUETTE_PORT'];
    }

    public function setInputs($request){
        Form();
        return Form::setInputs($request);
    }

    public function redirectWithBoolCondition(bool $condition, string $redirectTo, array $messages = [], string $type = "") {
        Form();
        if ($condition) {
            Form::send($redirectTo, $messages, $type);
            exit;
        }
    }

    public function generateUniqueUserCode(string $tableName, string $userNameColumnName, string $userNameInput): object{
        $userNameInput = trim($userNameInput);
        $userName = strtok($userNameInput, ' '); // Obtenemos el primer nombre (si está compuesto por varios)
        $db = new Database;
        $db->prepare();
        $existingUserCount = $db
            ->select()
            ->count()
            ->from($tableName)
            ->where($userNameColumnName, $userName)
            ->execute()
            ->fetchColumn();
        $code = $existingUserCount > 0 ?
                $existingUserCount + 1 :
                1;
        return arrayToObject([
            'username' => $userName,
            'code' => $code
        ]);
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