<?php

namespace app\models;

use core\model\IQuery;

enum SqlCode: string implements IQuery
{
  case SelectTrainingMat = "
    SELECT
    tbl_f.nome AS name,
    tbl_p.nome AS job,
    tbl_t.nome AS training,
    tbl_ft.status,
    DATE_FORMAT(tbl_ft.data_vencimento, \"%d-%m-%Y\") AS date
    FROM tbl_funcionario_treinamento AS tbl_ft
    INNER JOIN tbl_funcionario AS tbl_f
    ON tbl_f.id = tbl_ft.id_funcionario
    INNER JOIN tbl_profissao as tbl_p
    ON tbl_p.id = tbl_ft.id_profissao
    INNER JOIN tbl_treinamento tbl_t
    ON tbl_t.id = tbl_ft.id_treinamento
    WHERE tbl_f.matricula = '{mat}'
    ORDER BY name, tbl_ft.data_vencimento;
";

  case SelectExistRegisterXls = "
      SELECT
      tbl_f.id AS employed_id,
      tbl_p.id AS job_id,
      tbl_t.id AS training_id
      FROM tbl_funcionario_treinamento AS tbl_ft
      INNER JOIN tbl_funcionario AS tbl_f
      ON tbl_f.id = tbl_ft.id_funcionario
      INNER JOIN tbl_profissao as tbl_p
      ON tbl_p.id = tbl_ft.id_profissao
      INNER JOIN tbl_treinamento tbl_t
      ON tbl_t.id = tbl_ft.id_treinamento
      WHERE tbl_f.nome = '{employed_name}'
      AND tbl_p.nome = '{job_name}'
      AND tbl_t.nome = '{training_name}';
  ";

  case Update = "
      UPDATE tbl_funcionario_treinamento
      SET status = {status}, data_vencimento = {date}
      WHERE id_funcionario = {employed_id}
      AND id_profissao = {job_id}
      AND id_treinamento = {training_id};
  ";

  case AuthenticateAdmin = "
    SELECT
    CASE
      WHEN (
        SELECT EXISTS (
          SELECT * 
          FROM tbl_admin 
          WHERE nome = '{name}' 
          AND senha = '{password}')
        ) 
      LIKE 1 THEN TRUE
      ELSE FALSE
    END AS status;
  ";

  public function match(?array $values): string
  {
    $index = 0;
    return preg_replace_callback(
      '/{[\w_]+}/',
      function () use (&$index, $values) {
        $replacement = $values[$index];
        ++$index;
        return $replacement;
      },
      $this->value
    );
  }
}
