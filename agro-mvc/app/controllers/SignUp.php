<?php

namespace app\controllers;

use app\views\ViewSignUp;

class SignUp
{
  public function null()
  {
    return ViewSignUp::homePage();
  }
}
