<?php

namespace app\classes;

use config\Credentials;
use mysqli;

class DataBase
{
  private ?object $db;

  public function __construct()
  {
    $this->db = new mysqli(
      hostname: Credentials::hostname(),
      username: Credentials::USERNAME,
      password: Credentials::PASSWORD,
      database: Credentials::DATABASE
    );
  }

  protected function syntaxSqlGeneretor(
    ?string $table,
  ) {
    //GERAR O SQL DA QUERY. POR EXEMPLO: INSERT, DELETE, ETC.
    //O OBJETO QUE USAR DEVE INFORMAR O TIPO DE QUERY, A TABELA E OS VALORES.
    //ESSA METODO PESQUISA OS FILDS DA TABELA.
    //DEPOIS MONTA O CORPO DO SQL.
    //ADICIONA OS VALORES.
    //RETORNA O SQL PRONTO.
  }
}
