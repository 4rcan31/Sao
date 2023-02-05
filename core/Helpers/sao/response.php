<?php


function res($response, $code = 200, $errorResponseBody = null, $errorResponseHeader = null){
    $res = new Response;
    $res->res($response,$code, $errorResponseBody, $errorResponseHeader);
    exit;
}