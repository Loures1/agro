<?php

namespace app\classes;

define('STATUS', 'status');

use InvalidArgumentException;
use app\classes\TableElement;

class StatusTraining extends TableElement
{
  const PATTERN = [
    'Completo',
    'Pendente'
  ];

  private bool $status;

  public function __construct(string $name)
  {
    $this->element = self::validade($name);
  }

  private function validade(string $name): string
  {
    if (in_array($name, self::PATTERN) == false) {
      throw new InvalidArgumentException(
        "Valor '{$name}' e invalido na Coluna Treinamento Obrigatorio"
      );
    }
    $this->status = ($name == 'Completo') ? 1 : 0;
    return $name;
  }

  public function __get(string $name): int
  {
    return match ($name) {
      STATUS => $this->status
    };
  }
}
