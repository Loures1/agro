<?php

namespace app\controllers;

use core\controller\Controller;
use core\model\Model;
use core\router\Route;
use core\uri\Method;

#[Controller('Training')]
class Training
{
  #[Route(Method::GET, '/training/get/$param')]
  public function get(string $mat): void
  {
    $name = Model::query(
      "SELECT nome, matricula FROM tbl_funcionario WHERE matricula = '{$mat}'"
    );
    dd($name);
  }
}
