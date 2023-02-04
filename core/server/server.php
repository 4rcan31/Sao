<?php


class Server
{



    public function RouteAbsolute2($route, $formato)
    {
        if ($formato == "php") {
            if (empty($_SERVER['DOCUMENT_ROOT'])) {
                $LINK = __DIR__ . "\\";
            } else {
                $LINK = $_SERVER['DOCUMENT_ROOT'] . "\\";
            }
        } else {
            $LINK = (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'https://') . $_SERVER['HTTP_HOST'] . "/";
        }

        return $LINK . $route;
    }

    public function RouteAbsolute($route){
        $protocol = 'https';
        if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
            $protocol = "http";
        }
        $protocol = $protocol . "://";
        $domain = $_SERVER['HTTP_HOST'];
        return $protocol . $domain . "/" . $route;
        // return $LINK.$route;
    }

}
