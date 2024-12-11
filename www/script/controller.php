<?php

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
      hostname: 'db_agro',
      username: 'root',
      password: '',
      database: 'agro'
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
    foreach($fields as $field){
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
    
    $fields = $this->fetch_fields_from_table(table: $db_tables[$this->params['target']]);
    $implode_fields = implode(', ', $fields);
    $query = ("
      INSERT INTO {$db_tables[$this->params['target']]}
      ({$implode_fields})
      VALUES(");
    $values_array = []; 
    foreach($fields as $field){
      array_push($values_array, "'{$this->params[$field]}'");
    }
    $query = $query . implode(', ', $values_array) . ')'; 
    $this->mysql->query($query); 
  }

  public function __invoke()
  {
    $request = self::REQUISITIONS[$this->params['request']];
    return $this->$request();
  }
}
