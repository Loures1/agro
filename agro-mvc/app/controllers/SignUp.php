<?php

namespace app\controllers;

use app\models\User;
use app\views\ViewSignUp;

class SignUp
{
  public function null()
  {
    return ViewSignUp::homePage();
  }

  public function insertSupervisorInDataBase()
  {
    $data = $_POST;
    //PEGA OS PARAMETROS DO $_POST
    //PASSA PARA MODEL USER(RESPONSAVEL CUIDAR DA PARTE DE USUARIO)
    //O MODEL EXECUTA
    //PASSA O RESULTADO PARA VIEW
  }
}
