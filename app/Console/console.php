<?php



Jenu::command('command1', function(){
    Jenu::print("Esto es el comando 1 y fue ejecutado por el comando 2");
});


Jenu::command('command2', function($args){

    Jenu::print('Este es el comando 2 y sera ejecutado por el comando 3');
    Jenu::execute('command1');
    Jenu::print("El comando 2 acaba de ejecutar al comando 1");


});


Jenu::command('command3', function(){
    Jenu::print("Este es el comando 3 y ejecutara al comando 2, y el comando 2 ejecutara al comando 1");
    Jenu::execute('command2');
    Jenu::print("El comando 3 acaba de ejecutar al comando 2");
});