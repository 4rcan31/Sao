<?php


function server(){
    import('server', false, '/core');
    return new Server;
}