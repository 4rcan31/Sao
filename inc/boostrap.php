<?php 

require 'core/app.php';


$app = new App(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);


return $app;


