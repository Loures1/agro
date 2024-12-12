<?php
include_once('config.php');

class Controller
{
  const REQUISITIONS = array(
    'query_db'
  );

  public  ?string $method;
  public  ?array  $params;
  private ?object $mysql;

  public function __construct()
  {
    $this->mysql = new mysqli(
      hostname: Config::$hostname,
      username: Config::USER,
      password: Config::PASSWORD,
      database: Config::DATABASE
    );
  }

  private function fetch_fields_from_table($table)
  {
    $fields = $this->mysql->query(
      "SHOW COLUMNS
      FROM {$table}
      WHERE (Field != 'id' and Field != 'data')"
    );

    $fields_array = [];
    foreach ($fields as $field) {
      array_push($fields_array, $field['Field']);
    }

    return $fields_array;
  }

  private function query_db()
  {
    $db_tables = array(
      'tbl_funcionario',
      'tbl_funcionario_profissao_treinamento',
      'tbl_profissao',
      'tbl_profissao_treinamento',
      'tbl_supervisor',
      'tbl_treinamento'
    );

    $sql = array(
      'INSERT INTO <table> (<fields>) VALUES (<values>)'
    );
    $fields = $this->fetch_fields_from_table(
      table: $db_tables[$this->params['target']]
    );
    $values_array = [];
    foreach ($fields as $field) {
      array_push($values_array, "'{$this->params[$field]}'");
    }
    $sql = $sql[$this->params['action']];
    $patterns = [
      '(<table>)',
      '(<fields>)',
      '(<values>)'
    ];
    $replacements = [
      $db_tables[$this->params['target']],
      implode(', ', $fields),
      implode(', ', $values_array)
    ];

    return preg_replace(
      $patterns,
      $replacements,
      $sql
    );
  }

  public function __invoke()
  {
    $request = self::REQUISITIONS[$this->params['request']];
    return $this->$request();
  }
}
