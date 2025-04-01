<?php

namespace app\models;

use app\models\Query;

class ModelAdmin extends Query
{
  private array $employeds;
  private array $jobs;
  private array $trainings;

  public function __construct()
  {
    $this->employeds = [];
    $this->jobs = [];
    $this->trainings = [];
    self::pushFromDataBase($this->employeds, SELECT_EMPLOYED);
    self::pushFromDataBase($this->jobs, SELECT_JOB);
    self::pushFromDataBase($this->trainings, SELECT_TRAINING);
  }

  private function pushFromDataBase(?array &$array, string $code): void
  {
    parent::__construct();
    $array = parent::execQuery($code)->fetch_all();
  }

  public function __get(string $name): array
  {
    return match ($name) {
      'employeds' => $this->employeds,
      'jobs' => $this->jobs,
      'trainings' => $this->trainings
    };
  }
}
