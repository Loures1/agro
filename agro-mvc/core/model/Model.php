<?php

namespace core\model;

use core\model\IQuery;
use core\model\Register;
use mysqli;

class Model
{
  private static function conn(): mysqli
  {
    return new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
  }

  public static function query(IQuery $code, ?array $values): mixed
  {
    $dataBase = self::conn();
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

  public static function multiQuery(IQuery $code, ?array $values): mixed
  {
    $dataBase = self::conn();
    $querys = array_map(
      fn($value) => $code->match($value),
      $values
    );
    $querys = implode(b'', $querys);
    $dataBase->multi_query($querys);
    $register = [];
    do {
      if ($result = $dataBase->store_result()) {
        $fetch = $result->fetch_assoc();
        $fetch = ($fetch != null) ? new Register($fetch) : null;
        array_push($register, $fetch);
      }
    } while ($dataBase->next_result());
    return $register;
  }
}
