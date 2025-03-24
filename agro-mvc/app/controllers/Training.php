<?php

namespace app\controllers;

use app\models\UpadateRegisterDatabase;
use app\classes\Prospector;
use app\classes\TablePath;
use app\models\ReportTraining;
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
      $this->RenderReceiverXlsObj = new RenderReceiverXls();
      $this->RenderReceiverXlsObj->view('assets/html/receiverXls.html');
    } elseif ($this->methodRequest == 'POST') {
      $tablePath = new TablePath($this->fileReceived);
      $prospector = new Prospector($tablePath);
      $update = new UpadateRegisterDatabase($prospector->registers);
      echo $update->status;
    }
  }
}
