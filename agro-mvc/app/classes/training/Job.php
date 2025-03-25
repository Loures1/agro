<?php

namespace app\classes\training;

use InvalidArgumentException;
use app\classes\training\TableElement;
use app\models\ModelRegister;

class Job extends TableElement
{
  private int $id;
  public function __construct(string $name)
  {
    $this->element = self::validade($name);
  }

  private function validade(string $name): string
  {
    $modelJob = new ModelRegister($name, TBL_JOB);
    if ($modelJob->id == null) {
      throw new InvalidArgumentException(
        "Profissao '{$name}' nao consta no Banco de Dados"
      );
    }
    $this->id = $modelJob->id;
    return $name;
  }

  public function __get(string $name): mixed
  {
    return match ($name) {
      ID => $this->id
    };
  }
}
