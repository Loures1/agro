<?php

namespace app\classes;

use app\classes\Query;

class Insert extends Query
{
  private ?array $values;
  private ?array $filds;
  private ?string $table;

  public function __construct(?string $table, ?array $values)
  {
    $this->pattern_sql = "INSERT INTO 'table' ('filds') VALUES ('values')";
    $this->table = $table;
    $this->values = $values;
    $this->filds = [];
  }


  public function syntaxGeneretor()
  {

  }

  public function getFilds()
  {
    $fetch = Query::fetchDataBase(
      "SELECT COLUMN_NAME
      FROM information_schema.COLUMNS
      WHERE TABLE_NAME = 'tbl_supervisor'
      AND COLUMN_NAME != 'id'
      AND COLUMN_NAME != 'status'
      AND COLUMN_NAME != 'data'"
    );
  }
}