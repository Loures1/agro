<?php

namespace app\classes;

use config\Credentials;
use mysqli;

class Query
{
  private ?mysqli $dataBase;

  public function __construct()
  {
    $this->dataBase = new mysqli;
  }
  public function execQuery($query)
  {
    $this->dataBase->connect(
      hostname: Credentials::getHost(),
      username: Credentials::USERNAME,
      password: Credentials::PASSWORD,
      database: Credentials::DATABASE
    );

    $result = $this->dataBase->query($query);
    $this->dataBase->close();
    return $result;
  }
}
