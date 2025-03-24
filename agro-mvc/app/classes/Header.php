<?php

namespace app\classes;

use app\classes\TableElement;
use app\classes\HeaderModel;
use InvalidArgumentException;

class Header extends TableElement
{
  public function __construct(?array $contentTable)
  {
    $this->element = self::validateHeader($contentTable);
  }

  private function validateHeader(?array $header): ?array
  {
    if (HeaderModel::get(COLUMN_NUM) != count($header)) {
      $num_header_file = count($header);
      $num_header = HeaderModel::get(COLUMN_NUM);
      throw new InvalidArgumentException(
        "Ha '{$num_header_file}' colunas na tabela. Deveria ter: '{$num_header}'"
      );
    }
    foreach ($header as $key => $value) {
      if ($value != HeaderModel::get($key)) {
        $header = HeaderModel::get($key);
        throw new InvalidArgumentException(
          "Cabecalho da Tabela Errado.
          Deveria ser: '{$header}'. Mas e '{$value}'"
        );
      }
    }
    return $header;
  }
}
