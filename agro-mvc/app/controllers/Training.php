<?php

namespace app\controllers;

use app\models\ReportTraining;
use app\views\RenderTraining;

class Training
{
  private ?ReportTraining $ReportTrainingObj;
  private ?RenderTraining $RenderTrainingObj;

  public function get($matEmployed)
  {
    $this->ReportTrainingObj = new ReportTraining($matEmployed);
    $this->RenderTrainingObj = new RenderTraining(
      $this->ReportTrainingObj->get()
    );

    $this->RenderTrainingObj->view('assets/html/reportTraining.html');
  }
}
