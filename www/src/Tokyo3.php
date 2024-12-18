<?php
include_once('config.php');

class Tokyo3 extends mysqli
{
  public ?string $target;
  public ?string $operation;
  public ?array $params;

  public function __invoke()
  {
    $this->connect(
      hostname: Config::HOST[php_uname(mode: 's')],
      username: Config::USER,
      password: Config::PASSWORD,
      database: Config::DATABASE
    );
    $sql = match ($this->operation) {
      'INSERT' => "INSERT INTO {$this->target}
                  ({$this->fetch_fields_from_table(opt: '__STR__')})
                  VALEUS
                  ({$this->match_params_from_fields_table()})",

      'SELECT' => "SELECT * FROM {$this->target}",
    };
    $this->close();
    return $sql;
  }

  private function fetch_fields_from_table($opt)
  {
    $query = $this->query(
      "SHOW COLUMNS
      FROM {$this->target}
      WHERE (Field != 'id' and Field != 'data')"
    );

    $fields = [];
    foreach ($query as $field) {
      array_push($fields, $field['Field']);
    }
    return match ($opt) {
      '__ARRAY__'   => $fields,
      '__STR__' => implode(', ', $fields),
    };
  }

  public function match_params_from_fields_table()
  {
    $fields = $this->fetch_fields_from_table(opt: '__ARRAY__');
    $values = [];
    foreach ($fields as $field) {
      array_push($values, "'{$this->params[$field]}'");
    }
    return implode(', ', $values);
  }
}
