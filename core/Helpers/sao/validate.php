<?php

function validate($data){
    return import('validate/validate.php', true, '/core', $data);
}
