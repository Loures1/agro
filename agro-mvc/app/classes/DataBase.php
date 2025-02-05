<?php

namespace app\classes;

use config\Credentials;
use mysqli;

abstract class Query
{
  protected ?string $pattern_sql;
  abstract function syntaxGeneretor();

  static function fetchDataBase($query)
  {
    $db = new mysqli(
      username: Credentials::USERNAME,
      hostname: Credentials::getHost(),
      password: Credentials::PASSWORD,
      database: Credentials::DATABASE 
    );
    
    return $db->query($query);
  }
}
