<?php


function view($html, $route = '', $format = 'php'){
    try {
       // import('Views', false, '/core');
        core('Views', false); //Importamos todo el core de las vistas
        if(empty($route)){
            import("Views/$html.$format", false);
        }else{
            import("$route/$html.$format", false, '/');
        }
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}