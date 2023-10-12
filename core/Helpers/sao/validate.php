<?php

function validate($data) : Validate{
    return import('validate/validate.php', true, '/core', $data);
}
