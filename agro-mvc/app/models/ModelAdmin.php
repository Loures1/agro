<?php

namespace app\models;

use app\models\Query;

class ModelAdmin extends Query
{
  protected  array $employeds = [];
  protected array $jobs = [];
  protected array $trainings = [];
  protected array $relation_job_training = [];
  protected array $relation_employed_training = [];

  public function __construct()
  {
    self::pushFromDataBase($this->employeds, SELECT_EMPLOYED);
    self::pushFromDataBase($this->jobs, SELECT_JOB);
    self::pushFromDataBase($this->trainings, SELECT_TRAINING);
    self::pushFromDataBase($this->relation_job_training, SELECT_JOB_TRAINING);
    self::pushFromDataBase($this->relation_employed_training, SELECT_EMPLOYED_TRAINING);
  }

  private function pushFromDataBase(?array &$array, string $code): void
  {
    parent::__construct();
    $registers = parent::execQuery($code)->fetch_all();
    $id = -1;
    foreach ($registers as $register) {
      if ($register[0] != $id) {
        $id = $register[0];
        $array[$id] = [];
      };
      array_push($array[$id], ...array_slice($register, 1));
    };
  }
}
