<?php

Jenu::command('make:token', function($args){
    isset($args[0]) ?  Jenu::success("The generated token is: ".bin2hex(random_bytes($args[0]))) :
                           Jenu::success("The generated token is: ".bin2hex(random_bytes(32)));
}, 'Generate tokens string', 'Sao:String');
