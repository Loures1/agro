<?php

namespace app\classes\training;

use app\classes\training\TableElement;
use DateTime;
use Exception;
use InvalidArgumentException;

class Date extends TableElement
{
  public function __construct(?string $date)
  {
    $this->element = ($date != null)
      ? self::validade($date)
      : 'NULL';
  }

  private function validade(string $date): string
  {
    try {
      $date = DateTime::createFromFormat('d/m/Y', $date);
      $date = "'{$date->format('Y-m-d')}'";
      return $date;
    } catch (Exception) {
      throw new InvalidArgumentException(
        "Formato '{$date}' na coluna Data de Vencimento esta errado"
      );
    }
  }
}
