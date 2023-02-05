<?php


function core($module, $return = true, $data = []){
    return import($module, $return, '/core', $data);
}
