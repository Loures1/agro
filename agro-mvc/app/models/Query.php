<?php

namespace app\models;

use mysqli;

class Query
{
  private ?mysqli $dataBase;

  public function __construct()
  {
    $this->dataBase = new mysqli;
  }

  public function execQuery(string $query): mixed
  {
    $this->dataBase->connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    $result = $this->dataBase->query($query);
    $this->dataBase->close();
    return $result;
  }
}
