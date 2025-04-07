<?php

namespace app\classes\admin;

use app\classes\admin\general_structs\Id;
use app\classes\admin\general_structs\Name;
use app\classes\admin\employed_structs\Mat;
use app\classes\admin\employed_structs\Tel;
use app\classes\admin\employed_structs\Email;
use app\classes\admin\Job;
use app\classes\admin\CollectionTraining;
use DateTime;

class Employed
{
  private Id $id;
  private Name $name;
  private Mat $mat;
  private Job $job;
  private CollectionTraining $trainings;
  private Tel $tel;
  private Email $email;
  private DateTime $date;

  public function __construct(
    int $id,
    string $name,
    string $mat,
    string $tel,
    string $email,
    string $date,
    ?array $job,
    ?array $trainings
  ) {
    $this->id = new Id($id);
    $this->name = new Name($name);
    $this->mat = new Mat($mat);
    $this->tel = new Tel($tel);
    $this->email = new Email($email);
    $this->date = new DateTime($date);
    foreach ($job as $id => $j) {
      $this->job = new Job($id, ...$j);
    };
    $this->trainings = new CollectionTraining($trainings);
  }

  public function __get(
    string $name
  ): Id|Name|Mat|Job|CollectionTraining|Tel|Email|DateTime {
    return match ($name) {
      'id' => $this->id,
      'name' => $this->name,
      'mat' => $this->mat,
      'job' => $this->job,
      'trainings' => $this->trainings,
      'tel' => $this->tel,
      'email' => $this->email,
      'date' => $this->date
    };
  }
}
