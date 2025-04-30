<?php

namespace core\model;

use core\model\IQuery;
use core\model\Register;
use mysqli;

class Model
{
  public static function query(IQuery $code, ?array $values): mixed
  {
    $dataBase = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    $fetch = $dataBase->query($code->match($values));
    $fields = array_map(
      fn($field) => $field->name,
      $fetch->fetch_fields()
    );
    $register = array_map(
      fn($register) => new Register(array_combine($fields, $register)),
      $fetch->fetch_all(),
    );
    return $register;
  }
}
