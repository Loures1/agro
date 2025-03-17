<?php

namespace app\classes;

define('ASSERT_EMPLOYED', 0);
define('ASSERT_HEADER_NUMBERS', 0);
define('ASSERT_JOB', 1);
define('ASSERT_HEADER_VALUES', 1);
define('ASSERT_TRAINING', 2);
define('ASSERT_RELATION_EMPLOYED_TRAINING', 3);
define('ASSERT_RELATION_EMPLOYED_JOB', 4);
define('ASSERT_RELATION_JOB_TRAINING', 5);
define('ASSERT_STATUS_SET', 6);
define('ASSERT_PATTERN_DATE', 7);

class Checker extends Query
{
  const HEADER_STANDART_STRUCTURE = [
    'Nome',
    'Profissão',
    'Treinamento Obrigatório',
    'Situação de Treinamento',
    'Data de Vencimento'
  ];

  const DATABASE_TABLES = [
    'tbl_funcionario'
  ];

  private ?bool $statusCellHeader;
  private ?bool $statusCellValues;

  public function __construct()
  {
    $this->statusCellHeader = false;
    $this->statusCellValues = false;
  }

  public function getStatusCellHeader(): bool
  {
    return $this->statusCellHeader;
  }

  public function verification(?int $flag, ?array $item): bool
  {
    return match ($flag) {
      HEADERS_CELL => self::verificationHeader($item),
      VALUES_CELL => self::verificationValues($item)
    };
  }

  public function verificationValues(?array $valeus): bool
  {
    foreach ($valeus as $value) {
      $return = self::assertValues($value);
      if ($return == false) {
        return false;
      }
    }
    return true;
  }

  private function assertValues(?array $values): void
  {
    for ($verification = 0; $verification < 7; $verification++) {
      $return = match ($verification) {
        ASSERT_EMPLOYED => 1
      };
    }
  }

  private function assertDataBase(?string $value, ?string $target): bool
  {
    $code = <<<EOT
      SELECT EXIST(SELECT * FROM "$target" AS t WHERE t.nome = "$value")
    EOT;
    parent::__construct();
    $return = parent::execQuery($code);
    $return = ($return->fetch_all() == true) ?: false;
    return $return;
  }

  private function verificationHeader(?array $heards): bool
  {
    for ($verification = 0; $verification < 2; $verification++) {
      $return = match ($verification) {
        ASSERT_HEADER_NUMBERS => self::assertHeaderNumbers(count($heards)),
        ASSERT_HEADER_VALUES => self::assertValuesHeader($heards)
      };
      if ($return == false) {
        break;
      }
    }
    $this->statusCellHeader = $return;
    return $this->statusCellHeader;
  }

  private function assertHeaderNumbers(?int $headerNumbersToBeAssert): bool
  {
    if (count(self::HEADER_STANDART_STRUCTURE) == $headerNumbersToBeAssert) {
      return true;
    }
    return false;
  }

  private function assertValuesHeader(?array $heardsToBeAssert): bool
  {
    foreach (self::HEADER_STANDART_STRUCTURE as $key => $value) {
      if ($value != $heardsToBeAssert[$key]) {
        return false;
      }
    }
    return true;
  }
}
