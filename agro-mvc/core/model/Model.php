<?php

namespace core\model;

use core\model\Query;
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
    $code = $code->match($values);

    return match (Query::type($code)) {
      Query::Select => self::select($code),
      Query::Insert => self::insert($code),
      Query::Update => self::update($code),
      Query::Delete => self::delete($code)
    };
  }

  private static function select(string $code): mixed
  {
    $dataBase = self::conn();
    $fetch = $dataBase->query($code);
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

  private static function insert(string $code): void
  {
    $dataBase = self::conn();
    $dataBase->query($code);
  }

  private static function update(string $code): void
  {
    $dataBase = self::conn();
    $dataBase->query($code);
  }

  private static function delete(string $code): void
  {
    $dataBase = self::conn();
    $dataBase->query($code);
  }
}
