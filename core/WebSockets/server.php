<?php

require 'client.php';


class serverWS{
    public $host = '';
    public $port;
    public $maximunBytesForRead;
    public $socket;
    public $connections = [];


    //server

    //client
    public $ipClient = '';
    public $portClient;
    public $events = [];
    public $clients = [];

    //class
    public $server;

    function __construct(string $host, int $port, int $maximunBytesForRead = 1024, string $timeZone = 'UTC'){
        $this->host = $host;
        $this->port = $port;
        date_default_timezone_set($timeZone);
        $this->maximunBytesForRead = $maximunBytesForRead;
    }

    public function listeningSocket(object $server){
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); //Creamos el socket master
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($this->socket, $this->host, $this->port); //le atribuimos la direccion ip y el puerto donde se ejecutara el socket
        socket_listen($this->socket); //Ponemos a escuchar el socket
        array_push($this->connections, $this->socket); //Agregamos el socket master en las conexiones
        $this->server = $server;
        $server->console("Server listening in ", 'server:address');
        //$this->executeEvent('run', [], null);
    }

    public function event(string $event, callable $eventExecute){
           array_push($this->events, [
                'event' => $event,
                'execute' => $eventExecute
           ]);
    }

    public function executeClients(){ //Esta es una funcion bloqueadora
        while(true){
            $reads = $writes = $exceptions = $this->connections;
            //Si no hay nuevos datos de lectura, socket select elimina al socket maestro de $reads, y si los hay (o sea que hay un nuevo cliente)
            //deja al socket maestro para luego hacer la nueva conneccion en el socket maestro
            socket_select($reads, $writes, $exceptions, 0);
            $reads = $this->newConnection($reads, $this->socket);
            $this->newDisconnection($reads);
            $this->executeEvent('send', [], null); //No hay cliente aun, pero se seteara en la clase cliente despues (usando sessiones)
            //$this->request($reads);
        }
        socket_close($this->socket);
    }

    //Detecta una nueva conexion del cliente
    private function newConnection(array|object $reads, object|array $masterSocket){ 
        if(in_array($masterSocket, $reads)){ //lo que va a buscar, donde lo va a buscar
            $newConnection = socket_accept($this->socket);
            $header = socket_read($newConnection, $this->maximunBytesForRead);
            $this->handshake($header, $newConnection, $this->host, $this->port);
            array_push($this->connections, $newConnection);
            $firstIndex = array_search($this->socket, $reads);
            unset($reads[$firstIndex]); //se elimina el socket maestro de la variable $reads, no entiendo muy bien por que
            socket_getpeername($newConnection, $this->ipClient, $this->port);
           // $this->console("New Connection Client: ", "client:address");
           //Este evento se dispara cuando un nuevo cliente se conecta
            $this->executeEvent('connected', $newConnection, null);  //El mensaje es null por que solamente se esta conectado, no envia ningun mensaje
            
            array_push($this->clients, [
                'id' => count($this->clients) + 1,
                'ip' => $this->ipClient,
                'port' => $this->port,
                'date' => date('Ymd'),
                'license' => date('Ymd').(count($this->clients) + 1).rand(1, 999),
                'socket' => $newConnection,
                'session' => []
            ]);
        }
        return $reads;
    }

    public function session(object|array $clientR, array $dataSession){
        for($i = 0; $i < count($this->clients); $i++){
            if($this->clients[$i]['socket'] === $clientR){
                $this->console("El cliente si logro entrar!");
                $this->clients[$i]['session'] = $dataSession;
            }
        }
    }   

    private function executeEvent(string $event, object|array $client, $message){
        for($i = 0; $i < count($this->events); $i++){
            if($this->events[$i]['event'] === $event){
                if($event == 'run'){
                    $this->console("se ejecuto!!!!!!");
                }
                $this->events[$i]['execute'](new client($client, $this->clients, $this->connections, $message, $event), $this->server);
            }
        }
    }

    //Detecta una conexion del cliente
    private function newDisconnection(array|object $reads){ 
        foreach($reads as $read){
            $data = socket_read($read, $this->maximunBytesForRead);
            if($data === '' || $data === false){
                $index = array_search($read, $this->connections);
                socket_getpeername($read, $this->ipClient, $this->portClient);
                $this->executeEvent('disconnected', $read, null); //No hay ningun mensaje por que el cliente se desconecto
                socket_close($read);
                unset($this->connections[$index]);
            }else{
                $this->request($data, $read);
            }
        }
    }

    private function request(string $message, $client){
        $message = $this->unmask($message);
        $message = json_decode($message, true);
        if($message){
            $this->executeEvent('message', $client, $message); //El cliente en efecto envio un mensaje
        }   
    }    

    private function handshake(string $requestHeader, $socket, $host, $port){
        $headers = array();
		$lines = preg_split("/\r\n/", $requestHeader);
		foreach($lines as $line){
			$line = chop($line); //elimina el ultimo caracter del string
			if(preg_match('/\A(\S+): (.*)\z/', $line, $matches)){
				$headers[$matches[1]] = $matches[2];
			}
		}

        $secKey = $headers['Sec-WebSocket-Key'];
		$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		//hand shaking header
		$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
		"Upgrade: websocket\r\n" .
		"Connection: Upgrade\r\n" .
		"WebSocket-Origin: $host\r\n" .
		"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
		"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
		socket_write($socket,$upgrade,strlen($upgrade));
    }

    public function console(...$prints){
        $console = "[".date('D M d H:i:s Y')."] ";
        $arrays = [];
        foreach($prints as $print){
            if($print === 'client:address'){
                $console = $console."(".$this->ipClient.":".$this->portClient.")";
            }else if($print === 'server:address'){
                $console = $console."(".$this->host.":".$this->port.")";
            }else{
                is_array($print) ? array_push($arrays, $print) :  $console = $console.$print;
            }
        }
        print($console."\n");
        count($arrays) != 0 ? var_dump($arrays) : null;
    }

	private function unmask(string $text){
        if(strlen($text) < 2) {
            // Si la cadena tiene menos de 2 caracteres, no se puede acceder al segundo carácter
            return '';
        }
		$length = ord($text[1]) & 127;
		if($length == 126){
			$masks = substr($text, 4, 4);
			$data = substr($text, 8);
		}else if($length == 127){
			$masks = substr($text, 10, 4);
			$data = substr($text, 14);
		}else{
			$masks = substr($text, 2, 4);
			$data = substr($text, 6);
		}
		$return = '';
		for($i = 0; $i < strlen($data); ++$i){
			$return .= $data[$i] ^ $masks[$i%4];
		}
		return $return;
	}

}

/* 

- Vos
    - Tus habilidades (blandas y duras)
    - Tus gustos
    - Tus pasiones
- Universidad
    - Que vas a estudiar (El nombre de la carrera)
    - Por que vas a estudiar eso
    - Donde vas a estudiar
    - El pensum
    - Hay alguna materia que pienses que te costara (Eso me lo preguntaron en la entrevista pasada)
    - Por que vas a estudiar ahi
    - Como esta el mercado laboral hacerca de esa carrera
    - Que podes trabajar con dicha carrera
- Gastos
    - Como vas a pagar la universidad
    - Como vas a pagar el trasnporte
    - Como vas a pagar gastos extras
    - Vas a trabajar? (Creo que esto de lo permite la funda si haces un tecnico)
*/
