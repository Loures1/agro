<?php

namespace app\models;

define('EMPLOYED_TABLE', 'tbl_funcionario');
define('TRAINING_TABLE', 'tbl_treinamento');

use DateTime;
use app\classes\Query;

class UpadateTrainig extends Query
{
  const CODE = <<<EOD
  UPDATE tbl_funcionario_treinamento
  SET status = {status}, data_vencimento={data_vencimento}
  WHERE id_funcionario={id_funcionario} AND id_treinamento={id_treinamento}
  EOD;

  public function updateDataBase(?array $registers): void
  {
    $date = ($registers[4] == null)
      ? 'NULL'
      : DateTime::createFromFormat('d/m/Y', $registers[4])->format('Y-m-d');
    $code = preg_replace(
      [
        '/{status}/',
        '/{data_vencimento}/',
        '/{id_funcionario}/',
        '/{id_treinamento}/'
      ],
      [
        ($registers[3] == 'Completo') ? 1 : 0,
        ($date == 'NULL') ? 'NULL' : "'{$date}'",
        self::fetchId($registers[0], EMPLOYED_TABLE),
        self::fetchId($registers[2], TRAINING_TABLE)
      ],
      self::CODE
    );
    parent::__construct();
    parent::execQuery($code);
  }

  private function fetchId(?string $target, string $flag): int
  {
    $code = <<<EOT
    SELECT id
    FROM $flag
    WHERE $flag.nome = '$target';
    EOT;
    parent::__construct();
    $result = parent::execQuery($code);
    return $result->fetch_row()[0];
  }
}
