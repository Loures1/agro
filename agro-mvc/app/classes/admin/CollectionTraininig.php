<?php

namespace app\classes\admin;

use app\classes\admin\Training;
use app\models\ModelAdmin;

class CollectionTraining
{
  private array $trainings;

  public function __construct(ModelAdmin $model)
  {
    $this->trainings = [];
    foreach ($model->trainings as $training) {
      $training = self::createTraining(...$training);
      self::push($training);
    };
  }

  private function createTraining(int $id, string $name, string $date): Training
  {
    $training = new Training($id, $name, $date);
    return $training;
  }

  private function push(Training $training): void
  {
    array_push($this->trainings, $training);
  }

  public function __get(string $name): array
  {
    return match ($name) {
      'trainings' => $this->trainings
    };
  }
}
