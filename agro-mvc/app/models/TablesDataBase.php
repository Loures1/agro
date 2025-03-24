<?php

namespace app\models;

class TablesDataBase
{
  const GET_ID = <<<EOD
    SELECT t.id
    FROM {target} AS t
    WHERE t.nome = '{name}'
  EOD;

  const ASSERT_RELATION = <<<EOD
    SELECT EXISTS
    (
    SELECT f.id, f.id_profissao, ft.id_treinamento
    FROM tbl_funcionario AS f
    INNER JOIN tbl_funcionario_treinamento as ft
    ON f.id = ft.id_funcionario
    WHERE f.id = {id_employed}
    AND f.id_profissao = {id_job}
    AND ft.id_treinamento = {id_training}
    )
  EOD;

  const UPDATE = <<<EOD
    UPDATE tbl_funcionario_treinamento
    SET status = {status}, data_vencimento={date}
    WHERE id_funcionario={id_employed} AND id_profissao={id_profissao} AND id_treinamento={id_training}
  EOD;

  static function getEmployed(): string
  {
    return $_ENV['EMPLOYED'];
  }

  static function getJob(): string
  {
    return $_ENV['JOB'];
  }

  static function getTraining(): string
  {
    return $_ENV['TRAINING'];
  }
}
