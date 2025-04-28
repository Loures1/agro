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
    $employed = Model::query(SqlCode::SelectEmployed, [$mat]);

    $done_trainings = Model::query(
      SqlCode::SelectTraining,
      [$employed->id, $employed->job_id, 'TRUE']
    );

    $not_done_trainings = Model::query(
      SqlCode::SelectTraining,
      [$employed->id, $employed->job_id, 'FALSE']
    );

    View::render('home_page', ['names' => null]);
  }
}
