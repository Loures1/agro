<?php

namespace app\controllers;

use core\controller\Controller;
use core\router\Route;
use core\uri\Method;

#[Controller('Training')]
class Training
{
  #[Route(Method::GET, '/training/get/$param')]
  public function getTrainingEmployed(string $mat): void
  {
    echo $mat;
  }
}
