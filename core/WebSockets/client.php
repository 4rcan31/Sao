<?php

class client{
    public $client;
	public $clients = [];
	public $connections = [];
	public $message = '';
	public $event = '';
/*     function __construct($client = null, $clients = [], $connections = [], $message = ""){
        $this->client = $client;
		$this->clients = $clients;
		$this->connections = $connections;
    } */

	function __construct($client, $clients, $connections, $message, $event){
		$this->client = $client;
		$this->clients = $clients;
		$this->connections = $connections;
		$this->message = $message;
		$this->event = $event;
	}

    public function send(array $message){
        $message = $this->mask(json_encode($message));
        socket_write($this->client, $message, strlen($message));
    }

	public function setClientBy(string $by, string $condition){
		for($i = 0; count($this->clients) > $i; $i++){ // [], [], [], []
			/* 
				[
					'id' => 1 ...
 				]
			*/
				if($this->clients[$i]['session'][$by] === $condition){//$by espera ser el indice donde se guarda el token y $condition se es pera que sea el token
					$this->client = $this->clients[$i]['socket'];
					return true;
				} 
			
		}
		return false;
	}

	public function message(){
		return $this->message;
	}

	public function client(){
		return $this->client;
	}


    private function mask(string $text){
		$b1 = 0x80 | (0x1 & 0x0f);
		$length = strlen($text);
		if($length <= 225){
			$header = pack('CC', $b1, $length);
		}else if($length > 125 && $length < 65536){
			$header = pack('CCn', $b1, 126, $length);
		}else if($length >= 65536){
			$header = pack('CCNN', $b1, 127, $length);
		}
		return $header.$text;
	}
}