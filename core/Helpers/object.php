<?php


function objectToArray(Object $object){
    return json_decode(json_encode($object), true);
}
