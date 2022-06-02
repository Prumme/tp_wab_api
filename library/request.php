<?php

class Request
{
    public static function getJsonBody()
    {
        $rawInput = file_get_contents("php://input");

        $json = json_decode($rawInput, true);

        return $json;
    }

    public static function getHeaders()
    {
        return getallheaders();
    }

    public static function getHeader($name, $fallback = "notfound")
    {
        $header =  Request::getHeaders();

        if (!isset($header[$name])){
            return $fallback;
        }
        return $header[$name];
    }
}