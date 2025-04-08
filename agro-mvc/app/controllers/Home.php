<?php

namespace app\controllers;

use core\Route;
use core\controller\Controller;
use core\uri\Method;

#[Controller('Home')]
class Home
{
  #[Route(Method::GET, '/')]
  public function landingPage(): void
  {
    echo 'ola';
  }
}
