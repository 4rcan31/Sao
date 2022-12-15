<?php 


function inithtml(){
    echo '<!DOCTYPE html>';
}

function html($p, $attributes = [], $lang = 'en'){
   echo add($p, 'html', $attributes);
}

function body($p, $attributes = []){
   echo add($p, 'body', $attributes);
}

function div($p, $attributes = []){
    echo add($p, 'div', $attributes);
 }

function h1($p, $attributes = []){
    echo add($p, 'h1', $attributes);
 }

 function h2($p, $attributes = []){
    echo add($p, 'h2', $attributes);
 }

 function h3($p, $attributes = []){
    echo add($p, 'h3', $attributes);
 }

 function h4($p, $attributes = []){
    echo add($p, 'h4', $attributes);
 }

 function h5($p, $attributes = []){
    echo add($p, 'h5', $attributes);
 }

 function h6($p, $attributes = []){
    echo add($p, 'h6', $attributes);
 }

 
 function linkh($p, $attributes = []){
    echo add($p, 'link', $attributes);
 }

 function title($title){
   echo '<title>'.$title.'</title>';
 }

 function newHtml($p, $name, $attributes = []){
    echo add($p, $name, $attributes);
 }










