<?php

namespace app\models;

use app\classes\Insert;
use config\Credentials;
use mysqli;

class User
{
  static function registerUser($table, $values)
  {
    $insert = new Insert($table, $values);
    $db = new mysqli(
      username: Credentials::USERNAME,
      hostname: Credentials::getHost(),
      password: Credentials::PASSWORD,
      database: Credentials::DATABASE
    );

    $db->query($insert->syntaxGeneretor());
    $db->close();
  }
}
