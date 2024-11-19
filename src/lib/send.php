<?php

function send($data, $httpResponseCode)
{
    header('Content-Type: application/json');
    http_response_code($httpResponseCode);
    echo json_encode($data);
    exit;
}
