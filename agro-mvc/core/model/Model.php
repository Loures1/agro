<?php

namespace core\model;

use mysqli;

class Model
{
  protected string $table;
  protected array $columns = ['*'];
  protected ?string $where = null;
  protected ?string $order_by = null;
  protected ?array $joins = [];

  protected mysqli $db;

  public function __construct(string $name)
  {
    $this->table = $name;

    $this->db = new mysqli(
      HOSTNAME,
      USERNAME,
      PASSWORD,
      DATABASE
    );
  }

  public function get(): ?array
  {
    $columns = implode(',', $this->columns);
    $joins = implode(" ", $this->joins);
    $sql = "select {$columns} from {$this->table} {$joins} {$this->where}";
    $fetch = $this
      ->db
      ->query($sql);

    return array_map(
      fn($register) => (object) $register,
      $fetch->fetch_all(MYSQLI_ASSOC)
    );
  }

  public function first(): object
  {
    return $this->get()[0];
  }

  public function join(
    string $name,
    string $variable_inside,
    string $condition,
    string $variable_outside
  ): self {
    $join = "inner join {$name} on {$variable_inside} {$condition} {$variable_outside}";
    array_push($this->joins, $join);
    return $this;
  }

  public function where(string $codition, ?array $values = null): self
  {
    $codition = "where {$codition}";
    if ($values) {
      foreach ($values as $key => $value) {
        $value = match (gettype($value)) {
          'integer' => $value,
          'string' => "'{$value}'",
          'boolean' => ($value) ? 'TRUE' : 'FALSE'
        };
        $codition = preg_replace("/:{$key}/", $value, $codition);
      }
    }
    $this->where = $codition;
    return $this;
  }

  public function orderBy(string $condition): self
  {
    $condition = "order by {$condition}";
    $this->order_by = $condition;
    return $this;
  }

  public function select(): Model
  {
    $this->columns = func_get_args();
    return $this;
  }

  public function insert(?array $values): self
  {
    $keys = implode(',', array_keys($values));
    $values = array_map(
      fn($value) => "'{$value}'",
      $values
    );
    $values = implode(',', $values);
    $sql = "insert into {$this->table} ($keys) values ($values)";
    $this->db->query($sql);
    return $this;
  }

  public function insertGetId(?array $values): object
  {
    $condition = array_map(
      fn($key, $value) => (gettype($value) == 'integer')
        ? "{$key}={$value}"
        : "{$key}='{$value}'",
      array_keys($values),
      $values
    );
    $condition = implode(" and ", $condition);

    return $this
      ->insert($values)
      ->select('id')
      ->where($condition)
      ->first();
  }

  public function update(?array $values): self
  {
    $values = array_map(
      fn($key, $value) => match (gettype($value)) {
        'integer' => "{$key}={$value}",
        'string' => ($value != 'NULL') ? "{$key}='{$value}'" : "{$key}={$value}"
      },
      array_keys($values),
      $values
    );
    $values = implode(',', $values);
    $sql = "update {$this->table} set {$values} {$this->where}";
    $this->db->query($sql);
    return $this;
  }

  public function delete(): self
  {
    $sql = "delete from {$this->table} {$this->where}";
    $this->db->query($sql);
    return $this;
  }

  public static function table(string $name): self
  {
    return (new static($name));
  }
}
