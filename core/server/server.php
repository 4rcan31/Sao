<?php


class Server
{



    public static function RouteAbsoluteStatic($route = null, $host = null){
        $protocol = 'https';
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
            $protocol = 'http';
        }
        $protocol = $protocol . '://';
        $host === null ?  $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost' :  $domain = $host;
        return $route == null ? $protocol . $domain."/" : $protocol . $domain . '/' . $route;
    }

    public function RouteAbsolute($route = null, $host = null) {
        $protocol = 'https';
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
            $protocol = 'http';
        }
        $protocol = $protocol . '://';
        $host === null ?  $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost' :  $domain = $host;
        return $route == null ? $protocol . $domain."/" : $protocol . $domain . '/' . $route;
    }

    public static function redirect($route){
        $route = trim($route, '/');
        header("Location: ".self::RouteAbsoluteStatic($route, null));
        exit;
    }
    

}
