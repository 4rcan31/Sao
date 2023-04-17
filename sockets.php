<?php


require_once 'core/WebSockets/server.php';


/* $server = new serverWS('localhost', 12345);
$server->listeningSocket($server);


$server->event('on', function($server){
    $server->console("Nuevo cliente conectado: ", 'client:address');
    $server->response();
});

$server->event('connected', function(){

});


$server->event('message', function($messsage, $client, $server){
    $client->send("Hola cliente, resibi tu mensaje ".$messsage);
    $server->console('Nuevo mensaje de cliente ', 'client:address');
});

$server->executeClients(); */

/* $server = new serverWS('localhost', 12345); 
$server->listeningSocket($server);


$server->event('connected', function($server){
    $server->console("New client connected: ", 'client:address');
});

$server->event('disconnected', function($server){
    $server->console('Client disconnected: ', 'client:address');
});

$server->event('message', function($messsage, $client, $server){
    if($messsage['message'] == 'ping'){
        $client->send([
            'message' => 'pong'
        ]);
    }
    $server->console('The new message of client: ', 'client:address', ' the message was: ', $messsage);
});


$server->executeClients();
 */


$server = new serverWS('localhost', 12345, 1024, 'UTC');
$server->listeningSocket($server);




$server->event('connected', function($client, $server){
    $server->console('New client connected ', 'client:address');
});

$server->event('disconnected', function($client, $server){
    $server->console('Client disconnected', 'client:address');
});

$server->event('message', function($client, $server){
    $server->console('A new message of client', 'client:address');
    $messsage = $client->message();
    $event = $messsage['event'];

    if($event === 'connect'){
        $server->session($client->client(), [
            'token' => $client->message()['token']
        ]);
        $client->send([
            'message' => "The Arduino was connected suscess"
        ]);
        $server->console("New Arduino was connected, the token was: ", $messsage['token']);
    }else if($event === 'ping'){
        $client->send([
            'message' => 'pong'
        ]);
    }
});


$server->event('send', function($client, $server){
    require_once 'db.php';
    MemoryDatabase::insert('events', [
        'userName' => 'This is a username',
        'idArduino' => 1,
        'licenseArduino' => 'jdcnowehfwecslefj',
        'indication' => 'on'
    ]);
    $events = MemoryDatabase::select('events');
    $licenesesArduino = $events['licenseArduino']; 
    $indications = $events['indication'];


    if(!empty($licenesesArduino)){
        for($i = 0; $i < count($licenesesArduino); $i++){
            $license = $licenesesArduino[$i];
            if($client->setClientBy('token', $license)){ //Esto es para mandar el mensaje hasta que el cliente exista!
                $client->send([
                    'indication' => $indications[$i] //tienen el mismo indice, por que en la tabla se espera que esten en la misma columna, siempre un indentificador Arduino tiene una indicacion
                ]);
            }
        }
    }
});




$server->executeClients();