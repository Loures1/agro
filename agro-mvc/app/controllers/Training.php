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
      ['table' => null]
    );
  }
}
