<?php


function model($modelName){
    return import('Models/'.$modelName.".php");
}
