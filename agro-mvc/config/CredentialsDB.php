<?php

namespace config;

class Credentials
{
  static function getHostname(): string
  {
    return $_ENV['HOSTNAME'];
  }

  static function getUsername(): string
  {
    return $_ENV['USERNAME'];
  }

  static function getPassword(): string
  {
    return $_ENV['PASSWORD'];
  }

  static function getDataBase(): string
  {
    return $_ENV['DATABASE'];
  }

}
