<?php

namespace core\Http;

class HttpResponse
{
    public static function redirect(string $url) 
    {
        header("Location: {$url}");
    }
}