<?php

namespace app\controllers;

use core\http\HttpResponse;
use core\router\Route;
use core\controller\Controller;
use core\router\TypeHint;
use core\uri\Method;

#[Controller('Home')]
class Home
{
  #[Route(Method::GET, '/', TypeHint::Null)]
  public function landingPage(): void
  {
    HttpResponse::view('home_page');
  }
}
