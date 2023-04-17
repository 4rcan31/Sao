<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esto es una prueba</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>
<body>
    <div class="container"><br><br>
        <div class="d-grid gap-2">
            <h2>Click for the connect websocket</h2>
            <button class="btn btn-primary" type="button" id = 'btnConnect'>Connect</button>
            <button class="btn btn-primary" type="button" id = 'btnPing'>Ping</button>
            <button class="btn btn-primary" type="button" id = 'btnConnectArduino'>Connect Arduino</button>
            <button class="btn btn-primary" type="button" id = 'disconnectBtn'>Disconnect</button>
        </div>
        <hr>
        <br><br>
        <label for="inputPassword5" class="form-label">Message</label>
        <input type="text" id="inputPassword5" class="form-control" aria-labelledby="passwordHelpBlock" style="border-color: black;">

        <br><br>

        <div id="console"></div>
        
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script>

    const consoleElement = document.getElementById("console");
    function addToConsole(message) {
        const newLine = document.createElement("p");
        newLine.innerText = message;
        consoleElement.appendChild(newLine);
    }

    function seeMessageInConsoleFromSocket(socket){
        socket.addEventListener('message', (event) => {
            console.log(event);
            addToConsole(event.data);
        });
    }


    const connectBtn = document.getElementById('btnConnect');
    connectBtn.addEventListener('click', function() { //Cuando aprete el boton de conectar, se conectara al servidor
        const socket = new WebSocket('ws://localhost:12345/socket.php');

        socket.onopen = function() {
            addToConsole("New connection from client"); //Enviara en la pantalla del cliente una nueva conexion
        };


/*         socket.onmessage = function(event) {
            console.log(`Mensaje recibido: ${event.data}`);
        }; */


        document.getElementById('btnPing').addEventListener('click', () => { //Cuando apriete el boton de "ping"
            socket.send(JSON.stringify({ //Enviera un mensaje al servidor, esperando a que le responga con un pong
                event: 'ping'
            }));

            seeMessageInConsoleFromSocket(socket) //se imprime el mensaje del servidor en la pantalla del cliente (se espera un pong)
        });

        document.getElementById('btnConnectArduino').addEventListener('click', () => {
            socket.send(JSON.stringify({
                event: 'connect',
                token: 'jdcnowehfwecslefj'
            }));

            seeMessageInConsoleFromSocket(socket) //se espera un conectado correctamente
        });


        document.getElementById('disconnectBtn').addEventListener('click', () => { //Cuando aprete el boton de desconectar, el cliente se desconectara del servidor
            socket.close();
            addToConsole("Close connection with the server from client"); //se enviara un mensaje en la pantalla del cliente
        });
    });

</script>
</body>
</html>

