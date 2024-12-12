<?php

class Config
{
  const HOSTNAME = [
    'Linux' => 'db_agro',
    'Windows' => 'localhost'
  ];
  public $hostname = self::HOSTNAME[php_uname(mode: 's')];
  const USER = 'root';
  const PASSWORD = '';
  const DATABASE = 'agro';
}
