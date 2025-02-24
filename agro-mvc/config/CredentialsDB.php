<?php

namespace config;

class Credentials
{
  static function getHostname()
  {
    return $_ENV['HOSTNAME'];
  }

  static function getUsername()
  {
    return $_ENV['USERNAME'];
  }

  static function getPassword()
  {
    return $_ENV['PASSWORD'];
  }

  static function getDataBase()
  {
    return $_ENV['DATABASE'];
  }

}
