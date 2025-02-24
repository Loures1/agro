<?php

namespace app\models;

use app\classes\Query;

class ReportTraining extends Query
{
  private ?string $sqlCode;
  private ?array $report;
  private ?int $idEmployed;

  public function __construct($matEmployed)
  {
    $this->report = null;
    $this->idEmployed = self::getIdEmployed($matEmployed);
    $this->sqlCode =
      "SELECT t.nome, ft.ativo
      FROM tbl_treinamento AS t
      INNER JOIN
      (
        SELECT c.id_treinamento,
        CASE
          WHEN ft.id_treinamento IS null THEN 0
          ELSE 1
        END ativo
        FROM tbl_funcionario_treinamento AS ft
        RIGHT JOIN
        (
          SELECT f.id AS id_funcionario, pt.id_treinamento
          FROM tbl_funcionario AS f
          CROSS JOIN tbl_profissao_treinamento AS pt
          ON f.id_profissao = pt.id_profissao
          WHERE f.id = {$this->idEmployed}
        ) AS c
        ON ft.id_treinamento = c.id_treinamento
        AND ft.id_funcionario = c.id_funcionario
      ) AS ft
      ON t.id = ft.id_treinamento
      ORDER BY ativo";
    $this->report = self::fetchReportTrainingInDataBase();
  }

  public function getReportTraining()
  {
    return $this->report;
  }

  private function getIdEmployed($matEmployed)
  {
    parent::__construct();
    $result = parent::execQuery(
      "SELECT f.id FROM tbl_funcionario 
      AS f WHERE f.matricula = '{$matEmployed}'"
    );
    return intval($result->fetch_row()[0]);
  }

  private function fetchReportTrainingInDataBase()
  {
    parent::__construct();
    $result = parent::execQuery(
      $this->sqlCode
    );
    return $result->fetch_all();
  }
}
