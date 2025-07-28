<?php

namespace app\controllers;

use Exception;
use core\router\Route;
use core\controller\Controller;
use core\http\HttpResponse;
use core\model\Model;
use core\router\TypeHint;
use core\session\Session;
use core\uri\Method;

#[Controller('Admin')]
class Admin
{
  #[Route(Method::GET, '/admin', TypeHint::Null)]
  public function authentication(): void
  {
    HttpResponse::view(
      'authentication_admin',
      ['error_authenticated' => false]
    );
  }

  #[Route(Method::POST, '/admin', TypeHint::Form)]
  public function auth(?array $credential): void
  {
    $credential['password'] = hash('sha256', $credential['password']);
    $authentication = Model::table('tbl_admin')
      ->where(
        'nome=:0 and senha=:1',
        [$credential['username'], $credential['password']]
      )
      ->get();

    if ($authentication) {
      $session = new Session;
      $session->authenticated = true;
      HttpResponse::redirect('/admin/dashboard');
    }

    HttpResponse::view('authentication_admin', ['error_authenticated' => true]);
  }

  #[Route(Method::GET, '/admin/dashboard', TypeHint::Null)]
  public function dashboard(): void
  {
    $session = new Session;

    if (!$session->authenticated) {
      HttpResponse::redirect('/admin');
    }

    $employeds = Model::table('tbl_funcionario as f')
      ->join('tbl_profissao as p', 'f.id_profissao', '=', 'p.id')
      ->where('f.status =:0', [true])
      ->select(
        'f.id as id',
        'f.nome as name',
        'f.matricula as mat',
        'p.nome as job',
        'f.telefone as tel',
        'f.email as email',
        'DATE_FORMAT(f.data, "%d-%m-%Y") as date'
      )
      ->get();

    $jobs = Model::table('tbl_profissao')
      ->where('status=:0', [true])
      ->select('id', 'nome as name', 'DATE_FORMAT(data, "%d-%m-%Y") as date')
      ->get();

    $trainings = Model::table('tbl_treinamento')
      ->where('status=:0', [true])
      ->select('id', 'nome as name', 'DATE_FORMAT(data, "%d-%m-%Y") as date')
      ->get();

    $relations_employed_training = Model::table('tbl_funcionario_treinamento as ft')
      ->join('tbl_treinamento as t', 'ft.id_treinamento', '=', 't.id')
      ->where('ft.status=:0', [true])
      ->select('ft.id_funcionario as id_employed', 't.nome as training_name')
      ->get();

    $relations_job_training = Model::table('tbl_profissao_treinamento as pt')
      ->join('tbl_treinamento as t', 'pt.id_treinamento', '=', 't.id')
      ->where('t.status=:0', [true])
      ->select('pt.id_profissao as id_job', 't.nome as training_name')
      ->get();

    HttpResponse::view(
      'admin_dashboard',
      [
        'employeds' => $employeds,
        'jobs' => $jobs,
        'trainings' => $trainings,
        'relations_employed_training' => $relations_employed_training,
        'relations_job_training' => $relations_job_training
      ]
    );
  }

  #[Route(Method::GET, '/admin/create/$param', TypeHint::Parameter)]
  public function create(string $target): void
  {
    $session = new Session;

    if (!$session->authenticated) {
      HttpResponse::redirect('/admin');
    }

    $title = match ($target) {
      'employed' => 'Criando Funcionario',
      'job' => 'Criando Profissao',
      'training' => 'Criando Treinamento'
    };

    $jobs = Model::table('tbl_profissao')
      ->where('status=:0', [true])
      ->select('id', 'nome as name')
      ->get();

    $trainings = Model::table('tbl_treinamento')
      ->where('status=:0', [true])
      ->select('id', 'nome as name')
      ->get();

    HttpResponse::view(
      'admin_create_edit',
      [
        'action' => 'create',
        'header' => null,
        'target' => $target,
        'title' => $title,
        'jobs' => $jobs,
        'trainings' => $trainings,
        'user_trainings' => null,
        'user_job' => null
      ]
    );
  }

  #[Route(Method::POST, '/admin/create', TypeHint::Json)]
  public function receiveCreateJson(?array $data): void
  {
    try {
      if ($data['target'] == 'employed') {

        $employed = Model::table('tbl_funcionario')
          ->insertGetId([
            'nome' => $data['name'],
            'matricula' => $data['mat'],
            'id_profissao' => (int) $data['job'],
            'telefone' => $data['tel'],
            'email' => $data['email']
          ]);

        $employed = Model::table('tbl_funcionario')
          ->where('id=:0', [(int) $employed->id])
          ->select('id', 'id_profissao as job_id')
          ->first();

        $trainings = Model::table('tbl_profissao_treinamento as pt')
          ->join('tbl_treinamento as t', 'pt.id_treinamento', '=', 't.id')
          ->where('pt.id_profissao=:0', [(int) $data['job']])
          ->select('t.id as id')
          ->get();

        foreach ($trainings as $training) {
          Model::table('tbl_funcionario_treinamento')
            ->insert([
              'id_funcionario' => (int) $employed->id,
              'id_profissao' => (int) $employed->job_id,
              'id_treinamento' => (int) $training->id
            ]);
        }
      }

      if ($data['target'] == 'job') {
        $job = Model::table('tbl_profissao')
          ->insertGetId([
            'nome' => $data['name']
          ]);

        $training_ids = $data['trainings'];

        foreach ($training_ids['add'] as $id) {
          Model::table('tbl_profissao_treinamento')
            ->insert([
              'id_profissao' => (int) $job->id,
              'id_treinamento' => (int) $id
            ]);
        }
      }

      if ($data['target'] == 'training') {
        Model::table('tbl_treinamento')
          ->insert([
            'nome' => $data['name']
          ]);
      }

      HttpResponse::json([0]);
    } catch (Exception $e) {
      HttpResponse::json([
        $e->getCode(),
        $e->getMessage()
      ]);
    }
  }

  #[Route(Method::GET, '/admin/edit/$param', TypeHint::Parameter)]
  public function edit(string $target): void
  {
    $session = new Session;

    if (!$session->authenticated) {
      HttpResponse::redirect('/admin');
    }
    preg_match('/(employed|job|training)(\d+)/', $target, $content);
    [$target, $id] = array_slice($content, 1);

    $title = match ($target) {
      'employed' => 'Editando Funcionario',
      'job' => 'Editando Profissao',
      'training' => 'Editando Treinamento'
    };

    if ($target == 'employed') {
      $header = Model::table('tbl_funcionario')
        ->where('id=:0 and status=:1', [(int) $id, true])
        ->select('id', 'nome as name', 'matricula as mat', 'telefone as tel', 'email')
        ->first();

      $user_job = Model::table('tbl_funcionario as f')
        ->join('tbl_profissao as p', 'f.id_profissao', '=', 'p.id')
        ->where('f.id=:0 and f.status=:1', [(int) $id, true])
        ->select('p.id as id', 'p.nome as name')
        ->first();

      $user_trainings = Model::table('tbl_funcionario_treinamento as ft')
        ->join('tbl_treinamento as t', 'ft.id_treinamento', '=', 't.id')
        ->where('ft.id_funcionario=:0', [(int) $id])
        ->select('t.id as id', 't.nome as name')
        ->get();
    }

    if ($target == 'job') {
      $header = Model::table('tbl_profissao')
        ->where('id=:0 and status=:1', [(int) $id, true])
        ->select('id', 'nome as name')
        ->first();

      $user_job = null;

      $user_trainings = Model::table('tbl_profissao_treinamento as pt')
        ->join('tbl_treinamento as t', 'pt.id_treinamento', '=', 't.id')
        ->where('pt.id_profissao=:0', [(int) $id])
        ->select('t.id as id', 't.nome as name')
        ->get();
    }

    if ($target == 'training') {
      $header = Model::table('tbl_treinamento')
        ->where('id=:0 and status=:1', [(int) $id, true])
        ->select('id', 'nome as name')
        ->first();
      $user_job = null;
      $user_trainings = null;
    }

    $jobs = Model::table('tbl_profissao')
      ->where('status=:0', [true])
      ->select('id', 'nome as name')
      ->get();

    $trainings = Model::table('tbl_treinamento')
      ->where('status=:0', [true])
      ->select('id', 'nome as name')
      ->get();

    HttpResponse::view(
      'admin_create_edit',
      [
        'action' => 'edit',
        'header' => $header,
        'target' => $target,
        'title' => $title,
        'jobs' => $jobs,
        'trainings' => $trainings,
        'user_job' => $user_job,
        'user_trainings' => $user_trainings
      ]
    );
  }

  #[Route(Method::POST, '/admin/edit', TypeHint::Json)]
  public function receiveEdit(?array $data): void
  {
    try {
      if ($data['target'] == 'employed' && $data['job'] == null) {
        Model::table('tbl_funcionario')
          ->where('id=:0', [(int) $data['id']])
          ->update([
            'nome' => $data['name'],
            'matricula' => $data['mat'],
            'telefone' => $data['tel'],
            'email' => $data['email']
          ]);
      }

      if ($data['target'] == 'employed' && $data['job'] != null) {
        Model::table('tbl_funcionario')
          ->where('id=:0', [(int) $data['id']])
          ->update([
            'nome' => $data['name'],
            'matricula' => $data['mat'],
            'id_profissao' => (int) $data['job'],
            'telefone' => $data['tel'],
            'email' => $data['email']
          ]);

        Model::table('tbl_funcionario_treinamento')
          ->where('id_funcionario=:0', [(int) $data['id']])
          ->delete();

        $trainings = Model::table('tbl_profissao_treinamento as pt')
          ->join('tbl_treinamento as t', 'pt.id_treinamento', '=', 't.id')
          ->where('pt.id_profissao=:0', [(int) $data['job']])
          ->select('t.id as id')
          ->get();

        foreach ($trainings as $training) {
          Model::table('tbl_funcionario_treinamento')
            ->insert([
              'id_funcionario' => (int) $data['id'],
              'id_profissao' => (int) $data['job'],
              'id_treinamento' => (int) $training->id
            ]);
        }
      }

      if ($data['target'] == 'job') {
        Model::table('tbl_profissao')
          ->where('id=:0', [(int) $data['id']])
          ->update([
            'nome' => $data['name']
          ]);

        $training_ids = $data['trainings'];

        $employeds = Model::table('tbl_funcionario')
          ->where('id_profissao=:0', [(int) $data['id']])
          ->select('id')
          ->get();

        foreach ($training_ids['remove'] as $id) {
          Model::table('tbl_profissao_treinamento')
            ->where(
              'id_profissao=:0 and id_treinamento=:1',
              [(int) $data['id'], (int) $id]
            )
            ->delete();

          Model::table('tbl_funcionario_treinamento')
            ->where(
              'id_profissao=:0 and id_treinamento=:1',
              [(int) $data['id'], (int) $id]
            )
            ->delete();
        }

        foreach ($training_ids['add'] as $id) {
          Model::table('tbl_profissao_treinamento')
            ->insert([
              'id_profissao' => (int) $data['id'],
              'id_treinamento' => (int) $id
            ]);

          foreach ($employeds as $employed) {
            Model::table('tbl_funcionario_treinamento')
              ->insert([
                'id_funcionario' => (int) $employed->id,
                'id_profissao' => (int) $data['id'],
                'id_treinamento' => (int) $id
              ]);
          }
        }
      }

      if ($data['target'] == 'training') {
        Model::table('tbl_treinamento')
          ->where('id=:0', [(int) $data['id']])
          ->update([
            'nome' => $data['name']
          ]);
      }

      HttpResponse::json([0]);
    } catch (Exception $e) {
      HttpResponse::json([
        $e->getCode(),
        $e->getMessage()
      ]);
    }
  }

  #[Route(Method::GET, '/admin/delete/$param', TypeHint::Parameter)]
  public function delete(string $target): void
  {
    $session = new Session;

    if (!$session->authenticated) {
      HttpResponse::redirect('/admin');
    }
    preg_match('/(employed|job|training)(\d+)/', $target, $content);
    [$target, $id] = array_slice($content, 1);

    $target = match ($target) {
      'employed' => 'tbl_funcionario',
      'job' => 'tbl_profissao',
      'training' => 'tbl_treinamento'
    };

    Model::table($target)
      ->where('id=:0', [(int) $id])
      ->delete();

    HttpResponse::redirect("/admin/dashboard");
  }
}
