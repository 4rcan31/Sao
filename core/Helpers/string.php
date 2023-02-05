<?php


function randomString($length){ //Genera un string aleatorio
    $rand_string = '';
    for($i = 0; $i < $length; $i++) {
        $number = random_int(0, 36);
        $character = base_convert($number, 10, 36);
        $rand_string .= $character;
    }
    return $rand_string;
}