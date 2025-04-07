<?php

namespace app\classes\admin;

class CollectionEmployed
{
  private array $employeds;

  public function __construct(?array $employeds)
  {
    $this->employeds = [];
    foreach ($employeds as $id => $employed) {
      $employed = self::createEmployed($id, ...$employed);
      self::push($employed);
    }
  }

  private function createEmployed(
    int $id,
    string $name,
    string $mat,
    string $tel,
    string $email,
    string $date,
    ?array $job,
    ?array $trainings
  ): Employed {
    $employed = new Employed($id, $name, $mat, $tel, $email, $date, $job, $trainings);
    return $employed;
  }

  private function push(Employed $employed): void
  {
    array_push($this->employeds, $employed);
  }
}
