<?php

namespace app\classes;

use DateTime;

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
    'tbl_funcionario',
    'tbl_profissao',
    'tbl_treinamento'
  ];

  const STATUS_SET = [
    'Completo',
    'Em Andamento',
    'Pendente',
    'Não Iniciado'
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

  public function getStatusCellValues(): bool
  {
    return $this->statusCellValues;
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

  private function assertValues(?array $values): bool
  {
    for ($verification = 0; $verification < 2; $verification++) {
      $return = match ($verification) {
        ASSERT_EMPLOYED, 
        ASSERT_JOB, 
        ASSERT_TRAINING => self::assertDataBase(
            $values[$verification], self::DATABASE_TABLES[$verification]),
        ASSERT_RELATIONS => self::assertRelationDataBase(
            $values[0], $values[1], $values[2]),
        ASSERT_STATUS_SET => in_array($values[3], self::STATUS_SET),
        ASSERT_PATTERN_DATE => self::validateDate($values[4])
      };

      if($return == false) {
        break;
      }
    }
    $this->statusCellValues = $return;
    return $this->statusCellValues;
  }

  private function validateDate(?string $date, string $format = 'd/m/Y'): bool
  {
   $d = DateTime::createFromFormat($format, $date);
   return $d && $d->format($format) == $date; 
  }

  private function assertRelationDataBase(
    ?string $employed, 
    ?string $job, 
    ?string $training): bool
    {
        $code = <<<EOT
            SELECT EXISTS(
            SELECT f.nome as EMPLOYED, p.nome AS JOB, t.nome AS TRAINING
            FROM tbl_funcionario_treinamento AS ft
            INNER JOIN tbl_funcionario AS f
            ON ft.id_funcionario = f.id
            INNER JOIN tbl_treinamento as t
            ON ft.id_treinamento = t.id
            INNER JOIN tbl_profissao AS p
            ON f.id_profissao = p.id
            WHERE f.nome = '$employed'
            AND p.nome = '$job'
            AND t.nome = '$training')
        EOT;
        parent::__construct();
        $return = parent::execQuery($code);
        $return = ($return->fetch_row()[0] == true) ?: false;
        return $return;
    }

  private function assertDataBase(?string $value, ?string $target): bool
  {
    $code = <<<EOT
      SELECT EXISTS(SELECT * FROM $target AS t WHERE t.nome = '$value')
    EOT;
    parent::__construct();
    $return = parent::execQuery($code);
    $return = ($return->fetch_row()[0] == true) ?: false;
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
