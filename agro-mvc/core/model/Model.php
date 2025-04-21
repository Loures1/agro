<?php

namespace core\model;

use core\model\IQuery;
use mysqli;

class Model
{
  private ?array $fields;
  private function __construct(?array $fields)
  {
    foreach ($fields as $key => $field) {
      if (count($field) == 1) {
        $fields[$key] = current($field);
      }
    }
    $this->fields = $fields;
  }

  public static function query(IQuery $code, ?array $values): mixed
  {
    $dataBase = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    $fetch = $dataBase->query($code->match($values));
    $fields = array_map(
      fn($field) => [$field->name],
      $fetch->fetch_fields()
    );
    foreach ($fetch->fetch_all() as $item) {
      foreach (array_keys($fields) as $key) {
        array_push($fields[$key], $item[$key]);
      }
    }
    $result = [];
    foreach ($fields as $field) {
      $result[$field[0]] = array_slice($field, 1);
    }
    return new Model($result);
  }

  public function __get(string $name): string|array
  {
    return $this->fields[$name];
  }
}
