<?php

namespace app\controllers;

use app\models\ReportTraining;

class Training
{
  private ?ReportTraining $ReportTrainingObj;

  public function get($matEmployed)
  {
    $this->ReportTrainingObj = new ReportTraining($matEmployed);
    var_dump(
      $this->ReportTrainingObj->getReportTraining()
    );
  }
}
