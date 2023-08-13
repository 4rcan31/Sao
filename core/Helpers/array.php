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

function isAssoc( $array ) {
	return array_keys( $array ) !== range( 0, count($array) - 1 );
}

function deleteElementArray(array $array, ...$indexs){
    for($i = 0; count($indexs) > $i; $i++){
        unset($array[$indexs[$i]]);
    }
    return sortIndex($array);
}


