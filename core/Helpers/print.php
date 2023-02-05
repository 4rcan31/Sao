<?php

function printfa(...$data){
    $echo = '';
    for($i = 0; count($data) > $i; $i++){
        $echo = $echo.$data[$i];
    }
    echo $echo."<br>";
}

function prettyPrint($array, $json = false){
    if($json){
        echo json_encode($array);
    }else{
        echo '<pre>';
        var_dump($array);
        echo "</pre>";
    }
}
