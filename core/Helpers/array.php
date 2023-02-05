<?php

function sortIndex($array){ //Ordena los indices de un array
    $return = [];
    foreach($array as $value){
        array_push($return, $value);
    }
    return $return;
}


function arrayToObject(Array $array){
    return json_decode(json_encode($array, JSON_FORCE_OBJECT));
}
