<?php

namespace app\controllers;

use app\views\ViewSignIn;
use app\models\User;

class SignIn
{
  private ?User $userModel;

  public function null()
  {
    return ViewSignIn::homePage();
  }

  public function assertUser()
  {
    $cpf = $_POST['cpf'];
    $senha = hash("sha256", $_POST['password']);
    $this->userModel = new User;
    if ($this->userModel->assertUser(
      target: 'tbl_supervisor',
      fields: ['*'],
      condition: "cpf='{$cpf}' AND senha='{$senha}'"
    ) == true) {
      return ViewSignIn::userAssert();
    }
  }
}
