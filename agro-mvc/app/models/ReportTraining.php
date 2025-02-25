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
      "SELECT
      t.nome, ft.status, ft.data_vencimento
      FROM tbl_funcionario_treinamento AS ft
      RIGHT JOIN tbl_treinamento AS t
      ON ft.id_treinamento = t.id
      WHERE ft.id_funcionario = {$this->idEmployed}";

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
