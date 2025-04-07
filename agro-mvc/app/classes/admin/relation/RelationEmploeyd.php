<?php

namespace app\classes\admin\relation;

use app\models\ModelAdmin;

class RelationEmploeyd extends ModelAdmin
{
  public function __construct()
  {
    parent::__construct();
  }

  private function replaceIdForItens(?array $replacements1, ?array $target): array
  {
    $replace = [];
    foreach ($replacements1 as $replacement) {
      $replace[$replacement] = [];
      array_push($replace[$replacement], ...$target[$replacement]);
    }
    return $replace;
  }

  private function relationEmployedJobTraining(): array
  {
    $relation_employed_job_training = $this->employeds;
    foreach ($relation_employed_job_training as $id_employed => &$employed) {
      $id_job = $employed[5];
      if (key_exists($id_employed, $this->relation_employed_training)) {
        array_push(
          $employed,
          self::replaceIdForItens(
            $this->relation_employed_training[$id_employed],
            $this->trainings
          )
        );
      }
      $employed[5] = [$id_job => $this->jobs[$id_job]];
      if (key_exists($id_job, $this->relation_job_training)) {
        array_push(
          $employed[5][$id_job],
          self::replaceIdForItens(
            $this->relation_job_training[$id_job],
            $this->trainings
          )
        );
      }
    }
    return $relation_employed_job_training;
  }

  public function __get(string $name): array
  {
    return match ($name) {
      'employeds' => self::relationEmployedJobTraining(),
    };
  }
}
