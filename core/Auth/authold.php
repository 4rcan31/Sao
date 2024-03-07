<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SauthOLD {
    private static $data;
    public static $token = '';
    public static $time;
    public static $nameSesion = 'session';

    public static function token(Array $payload, string $key, $encrypter = true, $algori = 'HS256'){
        $jwt = JWT::encode($payload, $key, $algori);
        if($encrypter){
            $jwt = core('Encrypt/encrypt.php')->encrypt($jwt, $key);
        }
        return $jwt;
    }

    public static function decode(string $token, string $key, $encrypter = true, $algori='HS256'){
        if($encrypter){
           
            $tokent = core('Encrypt/encrypt.php')->decrypt($token, $key);
            echo "<br>================================================ <br>";
            var_dump($token);
            echo "<br>================================================ <br>";
        }
        try {
            $token  = JWT::decode($token, new Key($key, $algori));
            echo "<br>================================================ <br>";
            var_dump($token);
            echo "<br>================================================ <br>";
        } catch (\Throwable $th) {
            $token = false;
        }
        /* Sauth::$data = $jwt; */
        return $token;
    }


    public static function start(string $token, string $key){
        try{
            $token = Sauth::decode($token, $key);

        }catch(Exception $e){
            return false;
        }
        Sauth::$data = $token;
        return true;
    }

    public static function data(string $key = ''){
        if(empty($key)){
            return Sauth::$data->data;
        }
        if(isset(Sauth::$data->data->$key)){
            return Sauth::$data->data->$key;
        }else{
            throw new Exception("El indice $key no existe");
        }
    }

    public static function set(Array $userData, string $key, int $timeInDays = 7, $encrypter = true,$algori = 'HS256'){
        self::$time = time() + (86400 * $timeInDays);
        self::$token = self::token([
            'iat' => time(), // Tiempo que inició el token
            'exp' => self::$time, // Tiempo que expirará el token 7 días
            'data' => $userData
        ], $key, $encrypter, $algori);
        return self::$token;
    }


    public static function loginClient() {
        try {
            setcookie(self::$nameSesion, self::$token, self::$time, '/'); // La cookie expirará en 7 días
        } catch (\Throwable $th) {
            throw new Exception("Error interno", 1);
        }

    }

    public static function loginServer(string $table, string $colum, int $id, $idColumName = 'id'){
        import('DataBase/ORM/orm.php', false, '/core');
        $db = new DataBase;
        $db->prepare();
        $db->select([$colum])->from($table)->where($idColumName, $id);
        if(!$db->execute()->exists()){
            throw new Exception("The user with id ".$id." dont exist", 1);
        }
        $db->prepare();
        $db->update($table, [
            $colum => self::$token
        ])->where($idColumName, $id);
        $db->execute();
    }
    

    public static function middleware($key){
        var_dump(Request::$cookies);
        return isset(Request::$cookies[self::$nameSesion]) && self::start(Request::$cookies[self::$nameSesion], $key) ?
                true : false;
    }

    public static function getToken(){
        return isset(Request::$cookies[self::$nameSesion]) && self::start(Request::$cookies[self::$nameSesion], $_ENV['APP_KEY']) ?
                Request::$cookies[self::$nameSesion] : null;
    }


}








