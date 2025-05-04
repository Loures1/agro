<?php

namespace app\controllers;

use core\router\Route;
use core\controller\Controller;
use core\router\TypeHint;
use core\uri\Method;
use core\view\View;

#[Controller('Admin')]
class Admin
{
  #[Route(Method::GET, '/admin', TypeHint::Null)]
  public function authentication(): void
  {
    View::render('authentication_admin');
  }

  #[Route(Method::POST, '/admin', TypeHint::Form)]
  public function auth(?array $credential): void
  {
    $credential['password'] = hash('sha256', $credential['password']);
    dd($credential);
  }
}
