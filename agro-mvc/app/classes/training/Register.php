<?php

namespace app\classes\training;

use InvalidArgumentException;
use app\classes\training\Employed;
use app\classes\training\Job;
use app\classes\training\TrainingRegister;
use app\classes\training\StatusTraining;
use app\classes\training\Date;
use app\models\ModelRegister;

class Register extends TableElement
{
  public function __construct(?array $contentTable)
  {
    $this->element = [];
    foreach ($contentTable as $register) {
      self::validade($register);
    }
  }

  private function validade(?array $register): void
  {
    $row = [];
    foreach ($register as $key => $value) {
      $item = match ($key) {
        EMPLOYED => new Employed($value),
        JOB => new Job($value),
        TRAINING => new TrainingRegister($value),
        STATUS_TRAINING => new StatusTraining($value),
        DATE => new Date($value)
      };
      array_push($row, $item);
    }
    if (ModelRegister::validadeRelation(...$row) == false) {
      throw new InvalidArgumentException(
        "Nao consta no banco de dados a relacao:
        '{$row[EMPLOYED]}','{$row[JOB]}', '{$row[TRAINING]}'"
      );
    }
    if ($row[STATUS_TRAINING]->status == 0 && $row[DATE] != 'NULL') {
      throw new InvalidArgumentException(
        "'{$row[EMPLOYED]}','{$row[JOB]}','{$row[TRAINING]}',
        '{$row[STATUS_TRAINING]}','{$row[DATE]}'.
        Status que consta 'Pendente' nao deve ter data"
      );
    }
    if ($row[STATUS_TRAINING]->status == 1 && $row[DATE] == 'NULL') {
      throw new InvalidArgumentException(
        "'{$row[EMPLOYED]}','{$row[JOB]}','{$row[TRAINING]}',
        '{$row[STATUS_TRAINING]}'.
        Status que consta 'Completo' deve ter data"
      );
    }
    array_push($this->element, $row);
  }
}
