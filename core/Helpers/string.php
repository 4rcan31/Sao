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


function token($length = 32) {
    return substr(bin2hex(
        random_bytes(ceil($length / 2))
    ), 0, $length);
}
