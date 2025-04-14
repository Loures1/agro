<?php

namespace app\controllers;

use core\router\Route;
use core\controller\Controller;
use core\uri\Method;
use core\view\View;

#[Controller('Home')]
class Home
{
  #[Route(Method::GET, '/')]
  public function landingPage()
  {
    $id = 1;
    return View::render('homePage', ['id' => $id]);
  }
}
