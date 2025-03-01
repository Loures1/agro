<?php

namespace app\models;

use app\classes\Insert;
use app\classes\SelectExists;
use config\Credentials;
use mysqli;

class User
{
  private ?Insert $insertObj;
  private ?SelectExists $selectExistsObj;
  private ?mysqli $dataBaseObj;

  private function execQueryDataBase(?string $query)
  {
    $this->dataBaseObj = new mysqli(
      hostname: Credentials::getHostname(),
      username: Credentials::getUsername(),
      password: Credentials::getPassword(),
      database: Credentials::getDataBase()
    );
    
    $returnDataBase = $this->dataBaseObj->query($query);
    $this->dataBaseObj->close();
    return (gettype(boolval($returnDataBase)) == 'boolean')
      ? null : $returnDataBase;
  }

  public function registerUser(?string $target, ?array $datas)
  {
    $this->insertObj = new Insert($target, $datas);
    self::execQueryDataBase($this->insertObj->getQuery());
  }

  public function assertUser($target, $fields, $condition): bool
  {
    $this->selectExistsObj = new SelectExists(
      $target,
      fields: $fields,
      condition: $condition
    );
    return boolval(
      self::execQueryDataBase($this->selectExistsObj->getQuery())
    );
  }
}
