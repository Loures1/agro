<?php

namespace app\classes;

use app\classes\Query;

class Insert implements Query
{
  const SYNTAX_SQL = "INSERT INTO target (columns) VALUES (values)";
  private ?string $target;
  private ?array $values;
  private ?array $columns;
  private ?string $query;

  public function __construct(?string $target, ?array $datas)
  {
    $this->columns = array_keys($datas);
    $this->values = array_values($datas);
    $this->target = $target;
    $this->query = preg_replace(
      [
        '/target/',
        '/columns/',
        '/values/'
      ],
      [
        $this->target,
        implode(', ', $this->columns),
        self::traitmentValuesFromQuery()
      ],
      self::SYNTAX_SQL
    );
  }

  private function traitmentValuesFromQuery(): string
  {
    $values = [];
    foreach ($this->values as $value) {
      array_push($values, "'{$value}'");
    }
    return implode(', ', $values);
  }

  public function getTarget(): string
  {
    return $this->target;
  }

  public function getValues(): array
  {
    return $this->values;
  }

  public function getColumns(): array
  {
    return $this->columns;
  }

  public function getQuery(): string
  {
    return $this->query;
  }
}
