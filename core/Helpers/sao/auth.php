<?php


function jwt(){
    return import('Auth/JwtSession.php', true, '/core');
}