<?php

namespace app\models;

use app\classes\training\Date;
use app\classes\training\Employed;
use app\classes\training\Job;
use app\classes\training\Register;
use app\classes\training\StatusTraining;
use app\classes\training\TrainingRegister;
use app\models\Query;

class UpadateRegisterDatabase extends Query
{
  private string $status;

  public function __construct(Register $registers)
  {
    foreach ($registers->element as $register) {
      self::update(...$register);
    };
  }

  private function update(
    Employed $employed,
    Job $job,
    TrainingRegister $training,
    StatusTraining $status,
    Date $date
  ): void {
    $code = preg_replace(
      [
        '/{status}/',
        '/{date}/',
        '/{id_employed}/',
        '/{id_profissao}/',
        '/{id_training}/'
      ],
      [
        $status->status,
        $date,
        $employed->id,
        $job->id,
        $training->id
      ],
      UPDATE
    );
    parent::__construct();
    parent::execQuery($code);
    $this->status = 'Update Feito';
  }

  public function __get(string $name): string
  {
    return match ($name) {
      STATUS => $this->status
    };
  }
}
