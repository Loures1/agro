<?php

namespace app\classes\admin;

use app\classes\admin\Training;
use app\classes\admin\RelationStructs;
  
class CollectionTraining
{
  private array $trainings;

  public function __construct(?array $trainings)
  {
    $this->trainings = [];
    foreach ($trainings as $id=>$training) { 
      if($training !=null) {
        $training = self::createTraining($id, ...$training);
        self::push($training);
      } else {
        self::push(null);
      }
    };
  }

  private function createTraining(
    int $id, 
    string $name, 
    string $date): Training
  {
    $training = new Training($id, $name, $date);
    return $training;
  }

  private function push(?Training $training): void
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
