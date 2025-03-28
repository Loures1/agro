<?php

namespace app\classes\training;

use InvalidArgumentException;
use app\classes\training\TableElement;
use app\models\ModelRegister;

class TrainingRegister extends TableElement
{
  private int $id;
  public function __construct(string $name)
  {
    $this->element = self::validade($name);
  }

  private function validade(string $name): string
  {
    $modelTraining = new ModelRegister($name, TBL_TRAINING);
    if ($modelTraining->id == null) {
      throw new InvalidArgumentException(
        "Treinamento '{$name}' nao consta no Banco de Dados"
      );
    }
    $this->id = $modelTraining->id;
    return $name;
  }

  public function __get(string $name): mixed
  {
    return match ($name) {
      ID => $this->id
    };
  }
}
