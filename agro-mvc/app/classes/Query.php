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
  public function execQuery($query): object
  {
    $this->dataBase->connect(
      hostname: Credentials::getHostname(),
      username: Credentials::getUsername(),
      password: Credentials::getPassword(),
      database: Credentials::getDataBase()
    );

    $result = $this->dataBase->query($query);
    $this->dataBase->close();
    return $result;
  }
}
