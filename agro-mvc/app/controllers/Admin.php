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

    $authentication = Model::query(SqlCode::AuthenticateAdmin, [
      'name' => $credential['username'],
      'password' => $credential['password']
    ]);

    $authentication = current($authentication);

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
    $employeds = Model::query(SqlCode::EmployedsForAdmin, [
      'status' => 'TRUE'
    ]);

    $jobs = Model::query(SqlCode::JobsForAdmin, [
      'status' => 'TRUE'
    ]);

    $trainings = Model::query(SqlCode::TrainingForAdmin, [
      'status' => 'TRUE'
    ]);

    $relations_employed_training = Model::query(
      SqlCode::RelationEmployedTraining,
      ['status' => 'TRUE']
    );

    $relations_job_training = Model::query(
      SqlCode::RelationJobTraining,
      ['status' => 'TRUE']
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

    $jobs = Model::query(SqlCode::JobsForAdmin, ['status' => 'TRUE']);

    $trainings = Model::query(SqlCode::TrainingForAdmin, ['status' => 'TRUE']);

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
        Model::query(SqlCode::CreateEmployed, [
          'name' => $data['name'],
          'mat' => $data['mat'],
          'id_job' => $data['job'],
          'tel' => $data['tel'],
          'email' => $data['email']
        ]);

        $employed = current(
          Model::query(SqlCode::SelectEmployedForCreate, [
            'name' => $data['name'],
            'mat' => $data['mat'],
          ])
        );

        $trainings = Model::query(SqlCode::JobTrainings, [
          'id' => $employed->job_id
        ]);

        foreach ($trainings as $training) {
          Model::query(SqlCode::CreateRelationEmployedTraining, [
            'employed_id' => $employed->id,
            'job_id' => $employed->job_id,
            'training_id' => $training->id
          ]);
        }
      }

      if ($data['target'] == 'job') {
        Model::query(SqlCode::CreateJob, [
          'name' => $data['name']
        ]);

        $job = current(
          Model::query(SqlCode::SelectJobForCreate, [
            'name' => $data['name']
          ])
        );

        $training_ids = $data['trainings'];

        foreach ($training_ids['add'] as $id) {
          Model::query(SqlCode::CreateRelationJobTraining, [
            'job_id' => $job->id,
            'training_id' => $id
          ]);
        }
      }

      if ($data['target'] == 'training') {
        Model::query(SqlCode::CreateTraining, [
          'name' => $data['name']
        ]);
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
      $header = current(Model::query(SqlCode::Employed, ['id' => $id]));
      $user_job = current(Model::query(SqlCode::EmployedJob, ['id' => $id]));
      $user_trainings = Model::query(SqlCode::EmployedTrainings, ['id' => $id]);
    }

    if ($target == 'job') {
      $header = current(Model::query(SqlCode::Job, ['id' => $id]));
      $user_job = null;
      $user_trainings = Model::query(SqlCode::JobTrainings, ['id' => $id]);
    }

    if ($target == 'training') {
      $header = current(Model::query(SqlCode::Training, ['id' => $id]));
      $user_job = null;
      $user_trainings = null;
    }

    $jobs =  Model::query(SqlCode::JobsForAdmin, ['status' => 'TRUE']);
    $trainings = Model::query(SqlCode::TrainingForAdmin, ['status' => 'TRUE']);

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

        Model::query(SqlCode::UpdateEmployed, [
          'name' => $data['name'],
          'mat' => $data['mat'],
          'tel' => $data['tel'],
          'email' => $data['email'],
          'id' => $data['id']
        ]);
      }

      if ($data['target'] == 'employed' && $data['job'] != null) {
        Model::query(SqlCode::UpdateEmployedWithJob, [
          'name' => $data['name'],
          'mat' => $data['mat'],
          'id_job' => $data['job'],
          'tel' => $data['tel'],
          'email' => $data['email'],
          'id' => $data['id']
        ]);

        Model::query(SqlCode::DeleteEmployedTraining, [
          'id' => $data['id']
        ]);

        $trainings = Model::query(SqlCode::JobTrainings, [
          'id' => $data['job']
        ]);

        foreach ($trainings as $training) {
          Model::query(SqlCode::CreateRelationEmployedTraining, [
            'employed_id' => $data['id'],
            'job_id' => $data['job'],
            'training_id' => $training->id
          ]);
        }
      }

      if ($data['target'] == 'job') {
        Model::query(SqlCode::UpdateJob, [
          'name' => $data['name'],
          'id' => $data['id']
        ]);

        $training_ids = $data['trainings'];

        $employeds = Model::query(SqlCode::SelectEmployedForEdit, [
          'job_id' => $data['id']
        ]);

        foreach ($training_ids['remove'] as $id) {
          Model::query(SqlCode::DeleteRelationJobTraining, [
            'job_id' => $data['id'],
            'training_id' => $id
          ]);

          Model::query(SqlCode::DeleteRelationEmployedTraining, [
            'job_id' => $data['id'],
            'training_id' => $id
          ]);
        }

        foreach ($training_ids['add'] as $id) {
          Model::query(SqlCode::CreateRelationJobTraining, [
            'job_id' => $data['id'],
            'training_id' => $id
          ]);

          foreach ($employeds as $employed) {
            Model::query(SqlCode::CreateRelationEmployedTraining, [
              'employed_id' => $employed->employed_id,
              'job_id' => $data['id'],
              'training_id' => $id
            ]);
          }
        }
      }

      if ($data['target'] == 'training') {
        Model::query(SqlCode::UpdateTraining, [
          'name' => $data['name'],
          'id' => $data['id']
        ]);
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
    preg_match('/(employed|job|training)(\d+)/', $target, $content);
    [$target, $id] = array_slice($content, 1);

    $target = match ($target) {
      'employed' => 'tbl_funcionario',
      'job' => 'tbl_profissao',
      'training' => 'tbl_treinamento'
    };

    Model::query(SqlCode::Delete, [
      'target' => $target,
      'id' => $id
    ]);

    HttpResponse::redirect("/admin/dashboard");
  }
}
