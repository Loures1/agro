<?php

namespace app\controllers;

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

  public function get($matEmployed)
  {
    $this->ReportTrainingObj = new ReportTraining($matEmployed);
    $this->RenderTrainingObj = new RenderTraining(
      $this->ReportTrainingObj->get()
    );

    $this->RenderTrainingObj->view('reportTraining.html');
  }

  public function post()
  {
    if($this->methodRequest == 'GET') {
      self::receiverXls();
    }
    elseif($this->methodRequest == 'POST') {
      self::checker();
    }
  }

  private function receiverXls()
  {
    $this->RenderReceiverXlsObj = new RenderReceiverXls();
    $this->RenderReceiverXlsObj->view('assets/html/receiverXls.html');
  }

  private function checker()
  {
    if (pathinfo($this->fileReceived['name'], PATHINFO_EXTENSION) != 'xlsx') {
      return self::fileTypeErr();
    }
    //fazer a verificacao do modelo. Ja fazer o prospector e checker entao.
    //fazer o update no banco
  }

  private function fileTypeErr()
  {
    echo "arquivo errado";
  }

}
