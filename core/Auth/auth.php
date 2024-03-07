<?php
import('Auth/token.php', false, '/core');

class Sauth {
    public static $token;

    public static function NewAuthServerSave(string $table, string $column, int $id, string $idColumnName = 'id') {
        import('DataBase/ORM/orm.php', false, '/core');
        $db = new DataBase;
        $db->prepare();
        $db->select([$column])->from($table)->where($idColumnName, $id);

        if (!$db->execute()->exists()) {
            throw new Exception("The user with id $id doesn't exists", 1);
        }

        $db->prepare();
        $db->update($table, [
            $column => self::$token = new Token()
        ])->where($idColumnName, $id);

        $db->execute();
    }

    public static function NewAuthClient(array $payload, string $key = null, int $timeInDays = 7) {
        $tokenClient = json_encode([
            'tokenSaveInDB' => self::$token->getToken(),
            'payload' => $payload
        ]);
        setcookie(
            'session',
            import('Encrypt/encrypt.php', true, '/core')->encrypt(
                $tokenClient, 
                $key == null ? $_ENV['APP_KEY'] : $key),
            time() + (86400 * $timeInDays),
            '/'
        );
    }



    public static function getPayLoadTokenClient(string $tokenRequest, string $key, string $input = '') {
        try {
            $tokenRequest = urldecode($tokenRequest);
            $encrypt = import('Encrypt/encrypt.php', true, '/core');
            $tokenDecrypt = $encrypt->decrypt($tokenRequest, $key);
            $tokenDecrypt = json_decode($tokenDecrypt);
            if($tokenDecrypt === null) {
                return false;
            }
            $payload = $tokenDecrypt->payload;
            return $input !== '' && property_exists($payload, $input) ? $payload->$input : $payload;
        } catch (Exception $th) {
            return false;
        }
    }

    public static function getPayLoadTokenAll(string $tokenRequest, string $key, string $input = '') {
        try {
            $tokenRequest = urldecode($tokenRequest);
            $encrypt = import('Encrypt/encrypt.php', true, '/core');
            $tokenDecrypt = $encrypt->decrypt($tokenRequest, $key);
            $tokenDecrypt = json_decode($tokenDecrypt);
            if($tokenDecrypt === null) {
                return false;
            }
            return $tokenDecrypt;
        } catch (Exception $th) {
            return false;
        }
    }
    

    

    public static function NewAuthServerJWT(array $payload, string $signature, string $algorithm = 'HS256') {
        return self::$token = new JsonWebToken($payload, $signature, $algorithm);
    }

    public static function middlewareAuthServerAndClient(string $userToken, string $key, string $table, string $column, int $id, string $idColumnName = 'id') {
        $userToken = urldecode($userToken);
        import('DataBase/ORM/orm.php', false, '/core');
        $tokenSaveDB = json_decode(import('Encrypt/encrypt.php', true, '/core')->decrypt($userToken, $key))->tokenSaveInDB;
        $db = new DataBase;
        $db->prepare();
        $db->select([$column])->from($table)->where($idColumnName, $id);

        if (!$db->execute()->exists()) { //Esto es por que se envio un token con un id, pero ese id no existe
            Sauth::logoutClient(); //A si que ese token guardado en el cliente se elimina 
            return false; //Y el middleware retorna false
        }
        $tokenSave = $db->execute()->all()->remember_token;
        if (is_array($tokenSave)) {
            return in_array($tokenSaveDB, $tokenSave, true);
        } elseif (is_string($tokenSave)) {
            return hash_equals($tokenSave, $tokenSaveDB);
        }

        return false;
    }

    public static function middlewareAuthJsonWebToken(string $token, string $signature, string $algorithm = 'HS256') {
        return new VerifyJsonWebToken($token, $signature, $algorithm);
    }

    public static function getPayloadAuthJsonWebToken(string $token, string $signature, string $algorithm = 'HS256') {
        return new getPayLoad($token, $signature, $algorithm);
    }

    public static function authenticableClient($key, $cookieName = 'session'){
        return !isset(Request::$cookies[$cookieName]) ? 
                [] : 
                json_decode(import('Encrypt/encrypt.php', true, '/core')->decrypt(urldecode(Request::$cookies[$cookieName]), $key))->payload;
    }


    public static function logoutServer(string $table, string $column, int $id, string $idColumnName = 'id'){
        import('DataBase/ORM/orm.php', false, '/core');
        $db = new DataBase;
        $db->prepare();
        $db->select([$column])->from($table)->where($idColumnName, $id);
        if (!$db->execute()->exists()) {
            throw new Exception("The user with id $id doesn't exist", 1);
        }
        $db->prepare();
        $db->update($table, [
            $column => null
        ])->where($idColumnName, $id);
        $db->execute();
        return;
    }

    public static function logoutClient($cookieName = 'session'){
        setcookie($cookieName, '', time() - 3600, '/');
        setcookie($cookieName, '', time() - 3600, '/', $_SERVER['SERVER_NAME']);
        if (isset($_COOKIE[$cookieName])) {
            unset($_COOKIE[$cookieName]);
        }
    }
}

