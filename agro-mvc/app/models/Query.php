<?php

namespace app\models;

use config\Credentials;
use mysqli;

class Query
{
  const EMPLOYED = 'tbl_funcionario';

  private ?mysqli $dataBase;

  public function __construct()
  {
    $this->dataBase = new mysqli;
  }

  public function execQuery(?string $query): mixed
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
