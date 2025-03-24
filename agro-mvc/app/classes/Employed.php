<?php

namespace app\classes;

use InvalidArgumentException;
use app\classes\TableElement;
use app\models\TablesDataBase;
use app\models\ModelRegister;

class Employed extends TableElement
{
  private int $id;
  public function __construct(string $name)
  {
    $this->element = self::validade($name);
  }

  private function validade(string $name): string
  {
    $modelEmployed = new ModelRegister($name, TablesDataBase::getEmployed());
    if ($modelEmployed->id == null) {
      throw new InvalidArgumentException(
        "Funcionario '{$name}' nao consta no Banco de Dados"
      );
    }
    $this->id = $modelEmployed->id;
    return $name;
  }

  public function __get(string $name): mixed
  {
    return match ($name) {
      ID => $this->id,
      ELEMENT => $this->element
    };
  }
}
