<?php
namespace App\Src\Core;

class Response
{
    public function setHttpStatusCode(int $statusCode)
    {
        http_response_code($statusCode);
    }

    public function close(int $statusCode)
    {
        http_response_code($statusCode);
        exit;
    }
}