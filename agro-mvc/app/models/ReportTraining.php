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
      'name' => null,
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

    $this->report['name'] = self::getNameEmployed();
    $this->report['training'] = self::fetchReportTrainingInDataBase();
    $this->report['meta_data'] = self::getMetaData();
  }

  public function getReportTraining()
  {
    return $this->report;
  }

  private function getMetaData()
  {
    $status_1_num = 0;
    $status_0_num = 0;
    $defated_data_number = 0;
    foreach($this->report['training'] as $item) {
      if($item[1] == true) {
        ++$status_1_num;
        (strtotime($item[2]) < strtotime(date('y-m-d'))) 
        ? ++$defated_data_number 
        : null;   
      } 
      else {
        ++$status_0_num;
      }
    }

    $meta_data = [
      'status_1_number_' => $status_1_num,
      'status_0_number' => $status_0_num,
      'defeated_data_number' => $defated_data_number
    ];

    return $meta_data;
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

  private function getNameEmployed()
  {
    parent::__construct();
    $result = parent::execQuery(
      "SELECT nome
      FROM tbl_funcionario
      WHERE id = '{$this->idEmployed}'"
    );

    return $result->fetch_all()[0];
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
