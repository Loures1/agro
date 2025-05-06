<?php

namespace app\controllers;

use app\models\SqlCode;
use core\router\Route;
use core\controller\Controller;
use core\http\HttpResponse;
use core\model\Model;
use core\router\TypeHint;
use core\session\Session;
use core\uri\Method;
use core\view\View;

#[Controller('Admin')]
class Admin
{
  #[Route(Method::GET, '/admin', TypeHint::Null)]
  public function authentication(): void
  {
    View::render('authentication_admin', ['error_authenticated' => false]);
  }

  #[Route(Method::POST, '/admin', TypeHint::Form)]
  public function auth(?array $credential): void
  {
    $credential['password'] = hash('sha256', $credential['password']);
    $authentication = current(Model::query(
      SqlCode::AuthenticateAdmin,
      array_values($credential)
    ));

    if ($authentication->status) {
      $session = new Session;
      $session->authenticated = true;
      HttpResponse::redirect('/admin/dashboard');
    }
    View::render('authentication_admin', ['error_authenticated' => true]);
  }

  #[Route(Method::GET, '/admin/dashboard', TypeHint::Null)]
  public function dashboard(): void
  {
    $session = new Session;
    if (!$session->authenticated) {
      HttpResponse::redirect('/admin');
    }
    $employeds = Model::query(SqlCode::EmployedsForAdmin, ['TRUE']);
    $jobs = Model::query(SqlCode::JobsForAdmin, ['TRUE']);
    $trainings = Model::query(SqlCode::TrainingForAdmin, ['TRUE']);
    View::render(
      'admin_dashboard',
      ['employeds' => $employeds, 'jobs' => $jobs, 'trainings' => $trainings]
    );
  }
}
