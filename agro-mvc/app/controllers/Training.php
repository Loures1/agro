<?php

namespace app\controllers;

use app\models\ReportTraining;

class Training
{
  private ?ReportTraining $ReportTrainingObj;

  public function show()
  {
    $this->ReportTrainingObj = new ReportTraining('Maria Oliveira');
    var_dump(
      $this->ReportTrainingObj->getReportTraining()
    );
  }
}
