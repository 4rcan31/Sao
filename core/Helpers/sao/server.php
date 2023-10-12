<?php


function server(){
    import('server', false, '/core');
    return new Server;
}

function serve($host = null){
    return server()->RouteAbsolute(null, $host);
 }


