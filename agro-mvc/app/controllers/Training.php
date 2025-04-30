<?php

namespace app\controllers;

use app\models\SqlCode;
use core\controller\Controller;
use core\model\Model;
use core\router\Route;
use core\uri\Method;
use core\view\View;

#[Controller('Training')]
class Training
{
  #[Route(Method::GET, '/training/get/$param')]
  public function get(string $mat): void
  {
    $table = Model::query(SqlCode::SelectTrainingMat, [$mat]);

    View::render(
      'training_employed',
      [
        'name' => ($table) ? $table[0]->name : null,
        'job' => ($table) ? $table[0]->job : null,
        'table1' => array_filter($table, fn($cell) => $cell->status == true),
        'table0' => array_filter($table, fn($cell) => $cell->status == false)
      ]
    );
  }
}
