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

  private function execQueryDataBase(?string $query): object
  {
    $this->dataBaseObj = new mysqli(
      hostname: Credentials::getHost(),
      username: Credentials::USERNAME,
      password: Credentials::PASSWORD,
      database: Credentials::DATABASE
    );
    $result = $this->dataBaseObj->query($query);
    $this->dataBaseObj->close();
    return $result;
  }

  public function registerUser(?string $target, ?array $datas)
  {
    $this->insertObj = new Insert($target, $datas);
    self::execQueryDataBase($this->insertObj->getQuery());
  }

  public function assertUser($target, $fields, $condition) : bool
  {
    $this->selectExistsObj = new SelectExists($target, $fields, $condition);
    $result = self::execQueryDataBase(
      $this->selectExistsObj->getQuery());
    return boolval($result->fetch_row()[0]);
  }
}