<?php

namespace config;

class Credentials
{
  const USERNAME = 'root';
  const PASSWORD = null;
  const DATABASE = 'agro';
  static function getHost()
  {
    return match (php_uname(mode: 's')) {
      'Linux' => 'db_agro',
      'Windows NT' => 'localhost'
    };
  }
}
