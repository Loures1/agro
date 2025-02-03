<?php

namespace config;

class Credentials
{ 
    static function username()
    {
        return null;
    } 

    static function hostname()
    {
        return match (php_uname(mode: 's')) {
            'Linux' => 'db_agro',
            'Windows' => 'localhost'
        }; 
    }

    static function password()
    {
        return null;
    }

    static function database()
    {
        return 'agro';
    }
}