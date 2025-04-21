<?php

namespace app\models;

use core\model\IQuery;

enum SqlCode: string implements IQuery
{
  case SelectEmployed = "
    SELECT
    f.id AS id,
    f.id_profissao AS job_id,
    f.nome AS name,
    f.matricula AS mat,
    p.nome AS job_name
    FROM tbl_funcionario AS f
    INNER JOIN tbl_profissao AS p
    ON f.id_profissao = p.id
    WHERE f.matricula = '{mat}'";

  case SelectTraining = "
    SELECT
    t.nome AS name,
    DATE_FORMAT(ft.data_vencimento, \"%d-%m-%Y\") AS date
    FROM tbl_funcionario_treinamento AS ft
    INNER JOIN tbl_treinamento AS t
    ON ft.id_treinamento = t.id
    WHERE ft.id_funcionario = {employed_id}
    AND ft.id_profissao = {job_id}
    AND ft.status = {status}";

  public function match(?array $values): string
  {
    $index = 0;
    return preg_replace_callback(
      '/{\w+}/',
      function () use (&$index, $values) {
        $replacement = $values[$index];
        ++$index;
        return $replacement;
      },
      $this->value
    );
  }
}
