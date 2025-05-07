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

  case EmployedsForAdmin = "
    SELECT
    tbl_f.id AS id,
    tbl_f.nome AS name,
    tbl_f.matricula AS mat,
    tbl_p.nome AS job,
    tbl_f.telefone AS tel,
    tbl_f.email AS email,
    DATE_FORMAT(tbl_f.data, \"%d-%m-%Y\") AS date
    FROM tbl_funcionario AS tbl_f
    INNER JOIN tbl_profissao AS tbl_p
    ON tbl_p.id = tbl_f.id_profissao
    WHERE tbl_f.status = {status};
  ";

  case JobsForAdmin = "
  SELECT
  tbl_p.id AS id,
  tbl_p.nome AS name,
  DATE_FORMAT(tbl_p.data, \"%d-%m-%Y\") AS date
  FROM tbl_profissao AS tbl_p
  WHERE tbl_p.status = {status};
  ";

  case TrainingForAdmin = "
  SELECT
  tbl_t.id AS id,
  tbl_t.nome AS name,
  DATE_FORMAT(tbl_t.data, \"%d-%m-%Y\") AS date
  FROM tbl_treinamento AS tbl_t
  WHERE tbl_t.status = {status};
  ";

  case Relation = "
  SELECT
  tbl_ft.id_funcionario AS id_employed,
  tbl_ft.id_profissao AS id_job,
  tbl_ft.id_trainamentos AS id_training
  FROM tbl_funcionario_treinamento AS tbl_ft
  WHERE tbl_ft.status = {status};
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
