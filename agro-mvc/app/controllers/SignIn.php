<?php

namespace app\controllers;

use app\views\ViewSignIn;

class SignIn
{
  public function null()
  {
    return ViewSignIn::homePage();
  }
}
