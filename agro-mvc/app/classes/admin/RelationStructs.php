<?php

namespace app\classes\admin;

use app\models\ModelAdmin;

class RelationStructs extends ModelAdmin
{
  public function __construct()
  {
    parent::__construct();
  }

  private function replaceIdForItens(?array $replacements, ?array $target): array
  {
    $replace = [];
    foreach ($replacements as $replacement) {
      $replace[$replacement] = [];
      array_push($replace[$replacement], ...$target[$replacement]);
    }
    return $replace;
  }

  private function relationJobTraining(): array
  {
    $relation_job_training = $this->jobs;
    foreach ($relation_job_training as $id => &$job) {
      if (key_exists($id, $this->relation_job_training)) {
        array_push(
          $job,
          self::replaceIdForItens(
            $this->relation_job_training[$id],
            $this->trainings
          )
        );
      } else {
        array_push($job, [null]);
      }
    };
    return $relation_job_training;
  }

  public function __get(string $name): array
  {
    return match ($name) {
      'employeds' => [],
      'jobs' => self::relationJobTraining(),
      'trainings' => $this->trainings
    };
  }
}
