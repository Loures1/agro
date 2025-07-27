<?php

namespace app\controllers;

use app\classes\xls_file\FileXls;
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
    $table = Model::table('tbl_funcionario_treinamento as ft')
      ->join('tbl_funcionario as f', 'ft.id_funcionario', '=', 'f.id')
      ->join('tbl_profissao as p', 'ft.id_profissao', '=', 'p.id')
      ->join('tbl_treinamento as t', 'ft.id_treinamento', '=', 't.id')
      ->orderBy('f.nome, ft.data_vencimento')
      ->where('f.matricula=:mat', ['mat' => $mat])
      ->select(
        'f.nome as name',
        'p.nome as job',
        't.nome as training',
        'ft.status as status',
        'DATE_FORMAT(ft.data_vencimento, "%d-%m-%Y") as date'
      )
      ->get();

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
    $file = (new FileXls($file))
      ->validade()
      ->prospector()
      ->prepe();

    foreach ($file as $data) {
      Model::table('tbl_funcionario_treinamento')
        ->where(
          'id_funcionario=:0 and id_profissao=:1 and id_treinamento=:2',
          [(int) $data->employed_id, (int) $data->job_id, (int) $data->training_id]
        )
        ->update([
          'status' => $data->status,
          'data_vencimento' => $data->date
        ]);
    }

    HttpResponse::redirect('/');
  }
}
