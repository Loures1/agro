<?php

namespace app\controllers;

use app\views\ViewHome;

class Home
{
  public function null(): mixed
  {
    return ViewHome::homePage();
  }
}
