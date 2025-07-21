<?php

namespace app\controllers;

use Exception;
use app\models\SqlCode;
use core\router\Route;
use core\controller\Controller;
use core\http\HttpResponse;
use core\model\Model;
use core\router\TypeHint;
use core\session\Session;
use core\uri\Method;
use mysqli;

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
    $authentication = current(Model::query(
      SqlCode::AuthenticateAdmin,
      array_values($credential)
    ));

    if ($authentication->status) {
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
    $employeds = Model::query(SqlCode::EmployedsForAdmin, ['TRUE']);
    $jobs = Model::query(SqlCode::JobsForAdmin, ['TRUE']);
    $trainings = Model::query(SqlCode::TrainingForAdmin, ['TRUE']);
    $relations_employed_training = Model::query(
      SqlCode::RelationEmployedTraining,
      ['TRUE']
    );
    $relations_job_training = Model::query(
      SqlCode::RelationJobTraining,
      ['TRUE']
    );
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

    HttpResponse::view(
      'admin_create_edit',
      [
        'action' => 'create',
        'header' => null,
        'target' => $target,
        'title' => $title,
        'jobs' => Model::query(SqlCode::JobsForAdmin, ['TRUE']),
        'trainings' => Model::query(SqlCode::TrainingForAdmin, ['TRUE']),
        'user_trainings' => null,
        'user_job' => null
      ]
    );
  }

  #[Route(Method::POST, '/admin/create', TypeHint::Json)]
  public function receiveCreateJson(?array $data): void
  {
    $db = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    try {
      if ($data['target'] == 'employed') {
        $db->query(
          "INSERT INTO tbl_funcionario
        (nome, matricula, id_profissao, telefone, email)
        VALUES ('{$data['name']}', '{$data['mat']}', {$data['job']}, '{$data['tel']}', '{$data['email']}')"
        );

        $employed = current(
          Model::query(SqlCode::SelectEmployedForCreate, [
            $data['name'],
            $data['mat'],
          ])
        );

        $trainings = Model::query(SqlCode::JobTrainings, [$employed->job_id]);

        foreach ($trainings as $training) {
          $db->query(
            "INSERT INTO tbl_funcionario_treinamento
          (id_funcionario, id_profissao, id_treinamento)
          VALUES ('{$employed->id}', '{$employed->job_id}', '{$training->id}')"
          );
        }
      }

      if ($data['target'] == 'job') {
        $db->query(
          "INSERT INTO tbl_profissao
        (nome)
        VALUES ('{$data['name']}')"
        );

        $job = current(
          Model::query(SqlCode::SelectJobForCreate, [$data['name']])
        );

        $training_ids = $data['trainings'];

        foreach ($training_ids['add'] as $id) {
          $db->query(
            "INSERT INTO tbl_profissao_treinamento
          (id_profissao, id_treinamento)
          VALUES ('{$job->id}', '{$id}')"
          );
        }
      }

      if ($data['target'] == 'training') {
        $db->query(
          "INSERT INTO tbl_treinamento
        (nome)
        VALUES ('{$data['name']}')"
        );
      }

      echo json_encode(0);
    } catch (Exception $e) {
      echo json_encode($e->getCode());
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
      $header = current(Model::query(SqlCode::Employed, [$id]));
      $user_job = current(Model::query(SqlCode::EmployedJob, [$id]));
      $user_trainings = Model::query(SqlCode::EmployedTrainings, [$id]);
    }

    if ($target == 'job') {
      $header = current(Model::query(SqlCode::Job, [$id]));
      $user_job = null;
      $user_trainings = Model::query(SqlCode::JobTrainings, [$id]);
    }

    if ($target == 'training') {
      $header = current(Model::query(SqlCode::Training, [$id]));
      $user_job = null;
      $user_trainings = null;
    }

    HttpResponse::view(
      'admin_create_edit',
      [
        'action' => 'edit',
        'header' => $header,
        'target' => $target,
        'title' => $title,
        'jobs' => Model::query(SqlCode::JobsForAdmin, ['TRUE']),
        'trainings' => Model::query(SqlCode::TrainingForAdmin, ['TRUE']),
        'user_job' => $user_job,
        'user_trainings' => $user_trainings
      ]
    );
  }

  #[Route(Method::POST, '/admin/edit', TypeHint::Json)]
  public function receiveEditJson(?array $data): void
  {
    $db = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    try {

      if ($data['target'] == 'employed' && $data['job'] == null) {
        $db->query(
          "UPDATE tbl_funcionario
        SET
        nome='{$data['name']}',
        matricula='{$data['mat']}',
        telefone='{$data['tel']}',
        email='{$data['email']}'
        WHERE id='{$data['id']}'"
        );
      }

      if ($data['target'] == 'employed' && $data['job'] != null) {
        $db->query(
          "UPDATE tbl_funcionario
        SET
        nome='{$data['name']}',
        matricula='{$data['mat']}',
        id_profissao='{$data['job']}',
        telefone='{$data['tel']}',
        email='{$data['email']}'
        WHERE id='{$data['id']}'"
        );

        $db->query(
          "DELETE FROM tbl_funcionario_treinamento
        WHERE id_funcionario='{$data['id']}'"
        );

        $trainings = Model::query(SqlCode::JobTrainings, [$data['job']]);

        foreach ($trainings as $training) {
          $db->query(
            "INSERT INTO tbl_funcionario_treinamento
          (id_funcionario, id_profissao, id_treinamento)
          VALUES ('{$data['id']}', '{$data['job']}', '{$training->id}')"
          );
        }
      }

      if ($data['target'] == 'job') {
        $db->query(
          "UPDATE tbl_profissao
        SET nome='{$data['name']}'
        WHERE id='{$data['id']}'"
        );

        $training_ids = $data['trainings'];

        $employeds = Model::query(SqlCode::SelectEmployedForEdit, [$data['id']]);

        foreach ($training_ids['remove'] as $id) {
          $db->query(
            "DELETE FROM tbl_profissao_treinamento
          WHERE id_profissao='{$data['id']}' AND id_treinamento='{$id}'"
          );
          $db->query(
            "DELETE FROM tbl_funcionario_treinamento
          WHERE id_profissao='{$data['id']}' AND id_treinamento='{$id}'"
          );
        }

        foreach ($training_ids['add'] as $id) {
          $db->query(
            "INSERT INTO tbl_profissao_treinamento
          (id_profissao, id_treinamento)
          VALUES ({$data['id']}, {$id})"
          );

          foreach ($employeds as $emplyed) {
            $db->query(
              "INSERT INTO tbl_funcionario_treinamento
            (id_funcionario, id_profissao, id_treinamento)
            VALUES ({$emplyed->employed_id}, {$data['id']}, {$id})"
            );
          }
        }
      }

      if ($data['target'] == 'training') {
        $db->query(
          "UPDATE tbl_treinamento
        SET nome='{$data['name']}'
        WHERE id={$data['id']}"
        );
      }
      echo json_encode(0);
    } catch (Exception $e) {
      echo json_encode($e->getCode());
    }
  }

  #[Route(Method::GET, '/admin/delete/$param', TypeHint::Parameter)]
  public function delete(string $target): void
  {
    $session = new Session;

    if (!$session->authenticated) {
      HttpResponse::redirect('/admin');
    }
    $db = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    preg_match('/(employed|job|training)(\d+)/', $target, $content);
    [$target, $id] = array_slice($content, 1);

    $target = match ($target) {
      'employed' => 'tbl_funcionario',
      'job' => 'tbl_profissao',
      'training' => 'tbl_treinamento'
    };

    $db->query("DELETE FROM {$target} where id={$id}");

    HttpResponse::redirect("/admin/dashboard");
  }
}
