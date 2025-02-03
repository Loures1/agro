<?php

namespace config;

class Credentials
{ 
    const USERNAME = null;
    const PASSWORD = null;
    const DATABASE = 'agro';
    const HOSTNAME = match (php_uname(mode: 's')) {
        'Linux' => 'db_agro',
        'Windows' => 'localhost'
    };
}