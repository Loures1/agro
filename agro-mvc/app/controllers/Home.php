<?php

namespace app\controllers;

use app\views\HomeView;

class Home
{
  public function null()
  {
    $view = new HomeView;
    return $view->homePage();
  }

  public function signIn()
  {
    $view = new HomeView;
    return $view->signInPage();
  }

  public function signUp()
  {
    $view = new HomeView;
    return $view->signUpPage();
  }
}
