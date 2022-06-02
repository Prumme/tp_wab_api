<?php

class Response{

    public static function json($statusCode, $header, $body)
    {
        http_response_code($statusCode);

        header("Content-Type: application/json");

        foreach ($header as $key => $value) {
            header("$key: $value");
        }
        
        echo json_encode($body);
    }
}