<?php

namespace app\classes;

use app\classes\Query;

class Insert extends Query
{
  private ?array $values;
  private ?array $fields;
  private ?string $table;

  public function __construct(?string $table, ?array $values)
  {
    $this->pattern_sql = "INSERT INTO table (fields) VALUES ('values')";
    $this->table = $table;
    $this->values = $values;
    $this->fields = [];
  }


  public function syntaxGeneretor()
  {

    $replacemnts = [
      $this->table,
      implode(", ", self::getFilds()),
      implode(", ", self::innerJoinFieldsValues())
    ];

    return preg_replace(
      pattern: ["'table'", "'fields'", "'values'"],
      replacement: $replacemnts,
      subject: $this->pattern_sql
    );
  }

  private function getFilds()
  {
    $fetch = Query::fetchDataBase(
      "SELECT COLUMN_NAME
      FROM information_schema.COLUMNS
      WHERE TABLE_NAME = 'tbl_supervisor'
      AND COLUMN_NAME != 'id'
      AND COLUMN_NAME != 'status'
      AND COLUMN_NAME != 'data'"
    );

    foreach ($fetch->fetch_all() as $field) {
      array_push($this->fields, $field[0]);
    }

    return $this->fields;
  }

  private function innerJoinFieldsValues()
  {
    $inner_join = [];
    foreach ($this->fields as $key) {
      if (!array_key_exists($key, $this->values)) {
        return false;
      }
      array_push($inner_join, "'{$this->values[$key]}'");
    }
    return $inner_join;
  }
}
