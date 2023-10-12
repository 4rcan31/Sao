<?php


function printColor($messaje, $color){
    print("\e[$color"."m$messaje\e[0m\n");
}

function consoleError($err){
    printColor("Error: ".$err, '0;31');
}

function consoleWarning(string $warn, bool $start = true){
    $start ? printColor("Warning: ".$warn, '1;33') : printColor($warn, '1;33');
}

function consoleSuccess($messaje, $start = true){
    $start ? printColor("Success: ".$messaje, '0;32') : printColor($messaje, '0;32');
}

