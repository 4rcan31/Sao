<?php 

require 'core/app.php';


$sao = new Sao(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);


return $sao;


