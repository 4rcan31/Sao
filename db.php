<?php


require 'core/Database/temp/MemoryDataBase.php';



MemoryDatabase::createTable('arduinos', ['id', 'name', 'license']);
MemoryDatabase::createTable('users', ['id', 'name', 'username', 'idArduino']);
MemoryDatabase::createTable('events', ['userName', 'idArduino', 'licenseArduino', 'indication']);

MemoryDatabase::insert('arduinos', [
    'id' => 1,
    'name' => "Arduino 1",
    'license' => rand(1, 100000)
]);

MemoryDatabase::insert('users', [
    'id' => 1,
    'name' => 'test', 
    'username' => 'test1',
    'idArduino' => 1
]);









//Queda crear una forma de ordenar los datos para la conexion y ejecutar 