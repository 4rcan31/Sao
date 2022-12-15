<?php


class Server
{
    //Captura la ip de quien cargue la pagina, devuelve esa ip en cuestion, si no encontro nada devuelve false.
    function BuscarIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = false;
        }
        return $ip;
    }
    //recibe como parametro una ip y devuelve un array con infomacion de esta.
    function InfoIp($ip)
    {
        if($ip != 0){
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
        }else{
            $Datos = array(false, "La ip: ".$ip." es 0");
        }



        return $Datos;
    }

    function TypeIp($ip)
    {
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

    public function getIpAddress()
    {
        $ipAddress = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->validateIp($_SERVER['HTTP_CLIENT_IP'])) {
            // check for shared ISP IP
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if ($this->validateIp($ip)) {
                    $ipAddress = $ip;
                    break;
                }
            }
        } else if (!empty($_SERVER['HTTP_X_FORWARDED']) && $this->validateIp($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->validateIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->validateIp($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_FORWARDED']) && $this->validateIp($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_SERVER['REMOTE_ADDR']) && $this->validateIp($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }else{
            $ipAddress = 0;
        }
        return $ipAddress;
    }

    public function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }

    function RouteAbsolute2($route, $formato){
        if($formato == "php"){
            if(empty($_SERVER['DOCUMENT_ROOT'])){
                $LINK = __DIR__."\\";
            }else{
                $LINK = $_SERVER['DOCUMENT_ROOT']."\\";
            }
        }else{
            $LINK = (stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'https://').$_SERVER['HTTP_HOST']."/";
        }

        return $LINK.$route;
    }

    function RouteAbsolute($route){
            $protocol = $_SERVER['REQUEST_SCHEME']."://";
            $domain = $_SERVER['HTTP_HOST'];
            return $protocol.$domain."/".$route;
           // return $LINK.$route;
        }
}
