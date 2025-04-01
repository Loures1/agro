<?php

namespace app\classes\admin;

use app\classes\admin\general_structs\Id;
use app\classes\admin\general_structs\Name;
use DateTime;

class Job
{
  private Id $id;
  private Name $name;
  private DateTime $date;

  public function __construct(int $id, string $name, string $date)
  {
    $this->id = new Id($id);
    $this->name = new Name($name);
    $this->date = new DateTime($date);
  }

  public function __get(string $name)
  {
    return match ($name) {
      'id' => $this->id,
      'name' => $this->name,
      'date' => $this->date
    };
  }
}
