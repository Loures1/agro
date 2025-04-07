<?php

namespace app\classes\admin;

use app\classes\admin\general_structs\Id;
use app\classes\admin\general_structs\Name;
use app\classes\admin\CollectionTraining;
use DateTime;

class Job
{
  private Id $id;
  private Name $name;
  private CollectionTraining $trainings;
  private DateTime $date;

  public function __construct(
    int $id,
    string $name,
    string $date,
    ?array $trainings
  ) {
    $this->id = new Id($id);
    $this->name = new Name($name);
    $this->date = new DateTime($date);
    $this->trainings = new CollectionTraining($trainings);
  }

  public function __get(string $name): Id|Name|CollectionTraining|DateTime
  {
    return match ($name) {
      'id' => $this->id,
      'name' => $this->name,
      'trainings' => $this->trainings,
      'date' => $this->date
    };
  }
}
