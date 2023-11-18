<?php 


class Jenu{

    public static array $args = [];
    public static string $command = '';
    public static array $commands = [];
    public static $date = "";
    public static array $commandsShouldBeExecuted = [];


    public static function set($args){
        self::$command = $args[1]; //El indice 1 es el comando
        self::$args = deleteElementArray($args, 1, 0); //Aca se elimina el argumento "jenu" y el comando
        self::$date = date('D.d.M.Y_H.i.s');
    }

    public static function getDate(){
        return self::$date;
    }

    public static function baseDir($dir = ""){
        return dirname(dirname(__DIR__)).$dir;
    }

    public static function condition(string $pront){
        $response = readline($pront);
        return $response == 'yes' || $response == 'YES' || $response == "Y" || $response == "y" ?
        true : false;
    }
    

    public static function print($text, $newLine = true){
        $newLine ?  print($text."\n") :  print($text);
    }

    public static function printRow(int $len = 100){
        $row = "";
        for($i = 0; $i < $len; $i++){
            $row = "=$row";
        }
        echo "\n$row\n";
    }

    public static function success(string $text, bool $start = true){
        consoleSuccess($text, $start);
    }

    public static function error(string $text){
        consoleError($text);
        exit(0);
    }

    public static function warn(string $text, bool $start = true){
        consoleWarning($text, $start);
    }

    public static function command(string $command, callable $execute, string $help = "undefained", $type = "undefained"){
        array_push(self::$commands, [
            'command' => $command,
            'executed' => $execute,
            'help' => $help,
            'type' => $type
        ]);
    }

    public static function get($needle, $error, $defaultValue = null){
        if (isset(Jenu::$args[$needle])) {
            return Jenu::$args[$needle];
        }
        if ($defaultValue !== null) {
            return $defaultValue;
        }
        Jenu::error($error);
        return 0;
    }


    public static function execute(string $command){
        for($i = 0; count(self::$commands) > $i; $i++){
            if(self::$commands[$i]['command'] == $command){
                self::$commands[$i]['executed'](Jenu::$args);
                return;
            }
        }

        self::error("The command '".$command."' not is definied");
    }

    public static function run(){
        for($i = 0; count(self::$commands) > $i; $i++){
            /* 
            Verificar si solo el primer argumento es igual, 
            por que solo el primero es el comando, los demas solamente son argumentos del comando
            */
            if(self::$commands[$i]['command'] == Jenu::$command){
                self::$commands[$i]['executed'](Jenu::$args);
                return;
            }
        }
        Jenu::print("Help");
        Jenu::execute('help');
        Jenu::print("\n");
        self::error("The command '".Jenu::$command."' not is definied");

    }

/*     public static function executeNodeProcess($nodeCommand, $processador = 'node') {
        $nodeCommand = "$processador $nodeCommand";
        // Configurar los descriptores de archivos
        $descriptorspec = array(
            0 => array("pipe", "r"), // stdin (lectura)
            1 => array("pipe", "w"), // stdout (escritura)
            2 => array("pipe", "w"), // stderr (escritura)
        );
    
        // Iniciar el proceso Node.js en segundo plano
        $process = proc_open($nodeCommand, $descriptorspec, $pipes);
    
        if (is_resource($process)) {
            // Configurar los descriptores de archivo como no bloqueantes
            stream_set_blocking($pipes[0], 0);
            stream_set_blocking($pipes[1], 0);
    
            // Leer y mostrar la salida estándar de Node.js en tiempo real
            while (true) {
                // Verificar si hay datos disponibles desde Node.js
                $output = fgets($pipes[1]);
    
                if ($output !== false) {
                    Jenu::print($output, false);
                    flush(); // Asegura que la salida se muestre en tiempo real
                }
    
                // Verificar si hay datos disponibles desde la consola de PHP (stdin)
                $input = fgets(STDIN);
    
                if ($input !== false) {
                    // Enviar datos desde la consola de PHP al proceso Node.js
                    fwrite($pipes[0], $input);
                }
    
                // Obtener el estado del proceso Node.js
                $status = proc_get_status($process);
    
                if (!$status['running']) {
                    break;
                }
            }
    
            // Obtener la salida de error de Node.js
            $outputError = stream_get_contents($pipes[2]);
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
    
            // Esperar a que el proceso Node.js termine
            proc_close($process);
    
            if ($status['exitcode'] !== 0) {
                Jenu::warn("Node say -> $outputError");
            }
        }
    } */


    //Esto no soporta entradas del cliente
     public static function executeNodeProcess($nodeCommand, $processador = 'node') {
        $nodeCommand = "$processador $nodeCommand";
        // Configurar los descriptores de archivos
        $descriptorspec = array(
            0 => array("pipe", "r"), // stdin
            1 => array("pipe", "w"), // stdout
            2 => array("pipe", "w"), // stderr
        );

        // Iniciar el proceso Node.js en segundo plano
        $process = proc_open($nodeCommand, $descriptorspec, $pipes);

        if (is_resource($process)) {
            // Cerrar la entrada estándar, ya que no la usamos
            fclose($pipes[0]);

            // Leer y mostrar la salida estándar de Node.js en tiempo real
            while (!feof($pipes[1])) {
                Jenu::print(fgets($pipes[1]), false);
                flush(); // Asegura que la salida se muestre en tiempo real
            }

            fclose($pipes[1]);

            // Obtener la salida de error de Node.js
            $outputError = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // Obtener el código de salida del proceso Node.js
            $nodeExitCode = proc_close($process);

            if ($nodeExitCode !== 0) {
                Jenu::warn("Node.js say -> $outputError");
            }
        }
    }

}