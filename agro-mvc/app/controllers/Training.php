<?php

namespace app\controllers;

use app\classes\Prospector;
use app\classes\Checker;
use app\models\ReportTraining;
use app\models\UpadateTrainig;
use app\views\RenderTraining;
use RenderReceiverXls;

class Training
{
  private ?string $methodRequest;

  private ?ReportTraining $ReportTrainingObj;
  private ?RenderTraining $RenderTrainingObj;

  private ?RenderReceiverXls $RenderReceiverXlsObj;
  private ?array $fileReceived;

  public function __construct()
  {
    $this->methodRequest = $_SERVER['REQUEST_METHOD'];
    $this->fileReceived = $_FILES ? $_FILES['file'] : null;
  }

  public function get(?string $matEmployed): void
  {
    $this->ReportTrainingObj = new ReportTraining($matEmployed);
    $this->RenderTrainingObj = new RenderTraining(
      $this->ReportTrainingObj->get()
    );

    $this->RenderTrainingObj->view('reportTraining.html');
  }

  public function post(): void
  {
    if ($this->methodRequest == 'GET') {
      self::receiverXls();
    } elseif ($this->methodRequest == 'POST') {
      if (self::checker() == true) {
        self::insert();
      }
    }
  }

  private function receiverXls(): void
  {
    $this->RenderReceiverXlsObj = new RenderReceiverXls();
    $this->RenderReceiverXlsObj->view('assets/html/receiverXls.html');
  }

  private function checker()
  {
    if (pathinfo($this->fileReceived['name'], PATHINFO_EXTENSION) != 'xlsx') {
      return self::fileTypeErr();
    }
    $path = $this->fileReceived['tmp_name'];
    $prospector = new Prospector($path);
    $checker = new Checker;
    $return = $checker->verification(
      HEADERS_CELL,
      $prospector->getRows(HEADERS_CELL)
    );
    if ($return == false) {
      return 'Arquivo Invalido';
    }
    $return = $checker->verification(
      VALUES_CELL,
      $prospector->getRows(VALUES_CELL)
    );
    if ($return == false) {
      return 'Registros Invalidos';
    }
    return true;
  }

  private function insert(): void
  {
    $path = $this->fileReceived['tmp_name'];
    $prospector = new Prospector($path);
    $updateTraining = new UpadateTrainig();
    foreach ($prospector->getRows(VALUES_CELL) as $values) {
      $updateTraining->updateDataBase($values);
    }
    echo 'Atualizado';
  }

  private function fileTypeErr(): void
  {
    echo "Tipo de Arquivo Errado";
  }
}
