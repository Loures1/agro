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
    $this->report = [
      'nameEmployed' => null,
      'professionEmployed' => null,
      'training' => null,
      'meta_data' => [
        'status_1_number' => null,
        'status_0_number' => null,
        'defeated_data_number' => null
      ]
    ];

    $this->idEmployed = self::getIdEmployed($matEmployed);
    $this->sqlCode =
      "SELECT
      t.nome, ft.status, ft.data_vencimento
      FROM tbl_funcionario_treinamento AS ft
      RIGHT JOIN tbl_treinamento AS t
      ON ft.id_treinamento = t.id
      WHERE ft.id_funcionario = {$this->idEmployed}";

    $this->report['nameEmployed'] = self::getNameEmployed();
    $this->report['professionEmployed'] = self::getProfessionEmployed();
    $this->report['trainingStatus'] = self::fetchReportTrainingInDataBase();
    $this->report['meta_data'] = self::getMetaData();
  }

  public function get(): array|null
  {
    return $this->report;
  }

  private function getMetaData(): array|null
  {
    $defated_data_number = 0;
    foreach ($this->report['trainingStatus'][1] as $item) {
      (strtotime($item[1]) < strtotime(date('y-m-d')))
        ? ++$defated_data_number
        : null;
    }

    $meta_data = [
      'status_1_number' => count($this->report['trainingStatus'][1]),
      'status_0_number' => count($this->report['trainingStatus'][0]),
      'defeated_data_number' => $defated_data_number
    ];

    return $meta_data;
  }

  private function getIdEmployed(?string $matEmployed): int
  {
    parent::__construct();
    $result = parent::execQuery(
      "SELECT f.id FROM tbl_funcionario 
      AS f WHERE f.matricula = '{$matEmployed}'"
    );
    return intval($result->fetch_row()[0]);
  }

  private function getNameEmployed(): string
  {
    parent::__construct();
    $result = parent::execQuery(
      "SELECT nome
      FROM tbl_funcionario
      WHERE id = '{$this->idEmployed}'"
    );

    return $result->fetch_all()[0][0];
  }

  private function getProfessionEmployed(): string
  {
    parent::__construct();
    $result = parent::execQuery(
      "SELECT p.nome
      FROM tbl_profissao as p
      JOIN tbl_funcionario as f
      ON f.id_profissao = p.id 
      WHERE f.id = {$this->idEmployed}"
    );
    return $result->fetch_all()[0][0];
  }

  private function fetchReportTrainingInDataBase(): array
  {
    parent::__construct();
    $result = parent::execQuery(
      $this->sqlCode
    );

    $status = [
      0 => [],
      1 => []
    ];

    foreach ($result->fetch_all() as $item) {
      ($item[1] == true)
        ? array_push($status[1], [$item[0], $item[2]])
        : array_push($status[0], $item[0]);
    }

    return $status;
  }
}
