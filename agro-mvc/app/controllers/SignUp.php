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
    $_POST['senha'] = hash(algo: 'sha256', data: $_POST['senha']);
    User::registerUser(table: 'tbl_supervisor', values: $_POST);
    ViewSignUp::registerUserStatus();
  }
}
