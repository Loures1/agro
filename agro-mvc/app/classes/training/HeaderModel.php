<?php

namespace app\classes\training;

class HeaderModel
{
  const COLUMMN_NUM = 5;
  const ONE_COLUMN = 'Nome';
  const TWO_COLUMN = 'Profissão';
  const THREE_COLUMN = 'Treinamento Obrigatório';
  const FOR_COLUMN = 'Situação de Treinamento';
  const FIVE_COLUMN = 'Data de Vencimento';

  public static function get(?int $key): ?string
  {
    return match ($key) {
      0 => self::ONE_COLUMN,
      1 => self::TWO_COLUMN,
      2 => self::THREE_COLUMN,
      3 => self::FOR_COLUMN,
      4 => self::FIVE_COLUMN,
      5 => self::COLUMMN_NUM
    };
  }
}
