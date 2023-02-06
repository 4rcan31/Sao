<?php


class Request{
    //Capture data
    public static $uri = ''; //Aca se guarda la ruta visitada por el cliente
    public static $method = ''; //Aca se guarda el metodo de la peticion
    public static $data; //Aca se guarda los datos mandados de la peticion
    public static $ip = ''; //Aca se guarda la ip del cliente que hace la peticion
    public static $requestTime; //Aca se guarda el tiempo empleado de la peticion
    public static $headers = []; //Aca se guardan todos los headers de la peticion
    public static $cookies = []; //Aca se guardan todas las cookies mandadas de la peticion
    public static $tokenRequest = ''; //Aca se guardara un token unico aleatorio de la peticion


    public static function capture(){
        Request::$method = $_SERVER["REQUEST_METHOD"];
        Request::$uri = (parse_url('/'.trim($_SERVER["REQUEST_URI"], '/'), PHP_URL_PATH));
        Request::$requestTime = $_SERVER['REQUEST_TIME'];   
        Request::$headers = Request::getAllHeaders();
        Request::$ip = Request::getIpAddress();
        Request::$data = Request::data();
        Request::$cookies = Request::getAllCookies();
        Request::$tokenRequest = randomString(10); 
    }




    public static function data(){
        $dataRequestInput = json_decode(file_get_contents("php://input"));
        $dataRequestPhp = $_REQUEST;
        $data = [];
        if(!empty($dataRequestInput) && !empty($dataRequestPhp)){
            $data = array_merge(objectToArray($dataRequestInput), $dataRequestPhp);
        }else if(!empty($dataRequestInput)){
            $data = objectToArray($dataRequestInput);
        }else if(!empty($dataRequestPhp)){
            $data = $dataRequestPhp;
        }else{
            $data = [];
        }
        return $data;
    }


    public static function getIpAddress(){
        $ipAddress = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && Request::validateIp($_SERVER['HTTP_CLIENT_IP'])) {
            // check for shared ISP IP
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (Request::validateIp($ip)) {
                    $ipAddress = $ip;
                    break;
                }
            }
        } else if (!empty($_SERVER['HTTP_X_FORWARDED']) && Request::validateIp($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && Request::validateIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && Request::validateIp($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_FORWARDED']) && Request::validateIp($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_SERVER['REMOTE_ADDR']) && Request::validateIp($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipAddress = 0;
        }
        return $ipAddress;
    }

    public static function validateIp($ip){
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }



    
    public static function getAllHeaders(){
        $headers = array();

        $copy_server = array(
            'CONTENT_TYPE'   => 'Content-Type',
            'CONTENT_LENGTH' => 'Content-Length',
            'CONTENT_MD5'    => 'Content-Md5',
        );

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $key = substr($key, 5);
                if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                    $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                    $headers[$key] = $value;
                }
            } elseif (isset($copy_server[$key])) {
                $headers[$copy_server[$key]] = $value;
            }
        }

        if (!isset($headers['Authorization'])) {
            if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
                $basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
                $headers['Authorization'] = 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass);
            } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
                $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
            }
        }

        return $headers;
    }


    public static function getAllCookies(){
        $return = [];
        if(isset(Request::getAllHeaders()['Cookie']) || !empty(Request::getAllHeaders()['Cookie'])){
            $cookies = explode(';', Request::getAllHeaders()['Cookie']);
            for($i = 0; count($cookies) > $i; $i++){
                $cookie = explode('=', $cookies[$i]);
                $return[$cookie[0]] = $cookie[1];
            }
        }
        return $return;
    }



    public function typeIp($ip){ // Esta funcion esta en proceso
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = "->IP servicios compartidos de Internet.";
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = "->IP con proxy";
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = "->IP limpia.";
        } else {
            $ip = '-> unknown';
        }
        return $ip;
    }



    function InfoIp($ip){ //Esta funcion require de internet para funcionar, ya que hace un request a una web
        if ($ip != 0) {
            $ch = curl_init('http://ipwhois.app/json/' . $ip);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response
            $ipwhois_result = json_decode($json, true);

            $Pais = $ipwhois_result['country'];
            $TimeZone  = $ipwhois_result['timezone'];
            $Region = $ipwhois_result['region'];
            $Continente = $ipwhois_result['continent'];
            $PrefijoPais = $ipwhois_result['country_phone'];
            $Latitud = $ipwhois_result['latitude'];
            $Longitud = $ipwhois_result['longitude'];
            $ISP = $ipwhois_result['isp'];
            $Ciudad = $ipwhois_result['city'];
            $Moneda = $ipwhois_result['currency'];

            $Datos = array($Pais, $TimeZone, $Region, $Continente, $PrefijoPais, $Latitud, $Longitud, $ISP, $Ciudad, $Moneda);
        } else {
            $Datos = array(false, "La ip: " . $ip . " es 0");
        }
        return $Datos;
    }

}


