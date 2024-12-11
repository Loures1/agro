<?php

class Controller
{
  const REQUISITIONS = array(
    'insert_db'
  );

  public  ?string $method;
  public  ?array  $params;
  private ?object $mysql;

  public function __construct()
  {
    $this->mysql = new mysqli(
      hostname: 'db_agro',
      username: 'root',
      password: '',
      database: 'agro'
    );
  }

  private function insert_db()
  {
    $db_tables = array(
      'tbl_funcionario',
      'tbl_funcionario_profissao_treinamento',
      'tbl_profissao',
      'tbl_profissao_treinamento',
      'tbl_supervisor',
      'tbl_treinamento'
    );

    $query = $this->mysql->query(
      "SHOW COLUMNS
      FROM {$db_tables[$this->params['target']]}
      WHERE (Field != 'id' and Field != 'data')"
    );

    $fields = [];

    foreach ($query as $field) {
      array_push($fields, $field['Field']);
    }

    $query = "INSERT INTO {$db_tables[$this->params['target']]} ({$fields[0]}";
    foreach (array_slice($fields, 1) as $field) {
      $query = $query . ', ' . $field;
    }

    $query = $query . ')';

    $query = $query . " VALUES ('{$this->params[$fields[0]]}'";

    foreach (array_slice($fields, 1) as $field) {
      $query = $query . ', ' . "'{$this->params[$field]}'";
    }

    $query = $query . ')';


    return $this->mysql->query($query);
  }

  public function __invoke()
  {
    $request = self::REQUISITIONS[$this->params['request']];
    return $this->$request();
  }
}
