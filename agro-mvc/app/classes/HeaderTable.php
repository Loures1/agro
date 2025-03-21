<?php

namespace app\classes;

use app\classes\HeaderModel;
use InvalidArgumentException;

class HeaderTable
{

  private ?array $header;

  public function __construct(?array $header)
  {
    $this->header = self::validateHeader($header);
  }

  private function validateHeader(?array $header): ?array
  {
    if (HeaderModel::get(COLUMN_NUM) != count($header)) {
      throw new InvalidArgumentException(
        'Ha' . count($header)
          . 'colunas na tabela. Deveria ter' . HeaderModel::get(COLUMN_NUM)
      );
    }
    foreach ($header as $key => $value) {
      if ($value != HeaderModel::get($key)) {
        throw new InvalidArgumentException(
          'Cabecalho da Tabela Errado. Deveria ser: '
            . HeaderModel::get($key) . '. Mas e' . $value
        );
      }
    }
    return $header;
  }

  public function __invoke(): ?array
  {
    return $this->header;
  }
}
