<?php

namespace app\controllers;

use app\models\User;
use app\views\ViewSignUp;

class SignUp
{
  private ?User $userModel;
  public function null()
  {
    return ViewSignUp::homePage();
  }

  public function insertSupervisorInDataBase()
  {
    $this->userModel = new User;
    $_POST['senha'] = hash(algo: 'sha256', data: $_POST['senha']);
    $this->userModel->registerUser(
      target: 'tbl_supervisor',
      datas: $_POST
    );
    ViewSignUp::registerUserStatus();
  }
}
