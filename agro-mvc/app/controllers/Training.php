<?php

namespace app\controllers;

use app\classes\xls_file\FileXls;
use app\models\SqlCode;
use core\controller\Controller;
use core\http\HttpResponse;
use core\model\Model;
use core\router\Route;
use core\router\TypeHint;
use core\uri\Method;

#[Controller('Training')]
class Training
{
  #[Route(Method::GET, '/training/get/$param', TypeHint::Parameter)]
  public function get(string $mat): void
  {
    $table = Model::query(SqlCode::SelectTrainingMat, [$mat]);
    HttpResponse::view(
      'training_employed',
      [
        'name' => ($table) ? $table[0]->name : null,
        'job' => ($table) ? $table[0]->job : null,
        'table1' => array_filter($table, fn($cell) => $cell->status == true),
        'table0' => array_filter($table, fn($cell) => $cell->status == false)
      ]
    );
  }

  #[Route(Method::GET, '/training/post', TypeHint::Null)]
  public function send_xls_file(): void
  {
    HttpResponse::view('send_xls_file');
  }

  #[Route(Method::POST, '/training/post', TypeHint::File)]
  public function store(?array $file): void
  {
    $file = FileXls::validadeFileType($file);
    $file = FileXls::prospector($file);
    $file = FileXls::prepe($file);
    Model::multiQuery(SqlCode::Update, $file);
    HttpResponse::redirect('/');
  }
}
