<?php 


class Jenu{

    public static array $args = [];
    public static array $commands = [];
    public static $date = "";
    public static array $commandsShouldBeExecuted = [];


    public static function set($args){
        self::$args = $args;
        self::$date = date('D.d.M.Y_H.i.s');
    }

    public static function getDate(){
        return self::$date;
    }
    

    public static function print($text){
        print($text."\n");
    }

    public static function success(string $text){
        consoleSuccess($text);
    }

    public static function error(string $text){
        consoleError($text);
    }

    public static function warn(string $text){
        consoleWarning($text);
    }

    public static function command(string $command, callable $execute){
        array_push(self::$commands, [
            'command' => $command,
            'executed' => $execute
        ]);
    }


    public static function execute(string $command){
        for($i = 0; count(self::$commands) > $i; $i++){
            if(self::$commands[$i]['command'] == $command){
                self::$commands[$i]['executed'](deleteElementArray(self::$args, 1, 0));
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
            if(self::$commands[$i]['command'] == self::$args[1]){
                self::$commands[$i]['executed'](deleteElementArray(self::$args, 1, 0));
                return;
            }
        }
        self::error("The command '".self::$args[1]."' not is definied");
    }

}