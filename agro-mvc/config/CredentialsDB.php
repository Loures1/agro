<?php

namespace config;

class Credentials
{
  const USERNAME = null;
  const PASSWORD = null;
  const DATABASE = 'agro';
  public function hostname()
  {
    return match (php_uname(mode: 's')) {
      'Linux' => 'db_agro',
      'Windows NT' => 'localhost'
    };
  }
}

