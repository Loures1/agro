<?php

namespace app\models;

use core\model\IQuery;
use core\model\exceptions\InvalidModelArgument;

enum SqlCode: string implements IQuery
{
  case TrainingsByMat = "
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
      WHERE tbl_f.nome = '{employed}'
      AND tbl_p.nome = '{job}'
      AND tbl_t.nome = '{training}';
  ";

  case UpdateEmployedTrainings = "
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

  case RelationEmployedTraining = "
  SELECT
  tbl_ft.id_funcionario AS id_employed,
  tbl_t.nome AS training_name
  FROM tbl_funcionario_treinamento AS tbl_ft
  INNER JOIN tbl_treinamento AS tbl_t
  ON tbl_t.id = tbl_ft.id_treinamento
  WHERE tbl_ft.status = {status};
  ";

  case RelationJobTraining = "
  SELECT
  tbl_pt.id_profissao AS id_job,
  tbl_t.nome AS training_name
  FROM tbl_profissao_treinamento AS tbl_pt
  INNER JOIN tbl_treinamento AS tbl_t
  ON tbl_pt.id_treinamento = tbl_t.id
  WHERE tbl_t.status = {status};
  ";

  case EmployedJob = "
  SELECT
  p.id AS id,
  p.nome AS name
  FROM tbl_funcionario AS f
  INNER JOIN tbl_profissao AS p
  ON f.id_profissao = p.id
  WHERE f.id = {id} AND f.status = TRUE
  ";

  case EmployedTrainings = "
  SELECT
  t.id AS id,
  t.nome AS name
  FROM tbl_funcionario_treinamento AS ft
  INNER JOIN tbl_treinamento AS t
  ON ft.id_treinamento = t.id
  WHERE ft.id_funcionario = {id}
  ";

  case JobTrainings = "
  SELECT
  t.id AS id,
  t.nome AS name
  FROM tbl_profissao_treinamento AS pt
  INNER JOIN tbl_treinamento AS t
  ON pt.id_treinamento = t.id
  WHERE pt.id_profissao = {id}
  ";

  case Employed = "
  SELECT
  f.id AS id,
  f.nome AS name,
  f.matricula AS mat,
  f.telefone AS tel,
  f.email AS email
  FROM tbl_funcionario AS f
  WHERE f.id = {id} AND f.status = TRUE
  ";

  case Job = "
  SELECT
  p.id AS id,
  p.nome AS name
  FROM tbl_profissao AS p
  WHERE p.id = {id} AND p.status = TRUE
  ";

  case Training = "
  SELECT
  t.id AS id,
  t.nome AS name
  FROM tbl_treinamento AS t
  WHERE t.id = {id} AND t.status = TRUE
  ";


  case SelectEmployedForCreate = "
  SELECT
  f.id AS id,
  f.id_profissao AS job_id
  FROM tbl_funcionario AS f
  WHERE f.nome = '{name}' AND f.matricula = '{mat}' AND f.status = TRUE
  ";

  case SelectJobForCreate = "
  SELECT
  p.id AS id
  FROM tbl_profissao AS p
  WHERE p.nome = '{name}' AND p.status = TRUE
  ";

  case CreateEmployed = "
  INSERT INTO tbl_funcionario (nome, matricula, id_profissao, telefone, email)
  VALUES ('{name}', '{mat}', {id_job}, '{tel}', '{email}')
  ";

  case CreateJob = "
  INSERT INTO tbl_profissao
  (nome)
  VALUES ('{name}')
  ";

  case CreateTraining = "
  INSERT INTO tbl_treinamento
  (nome)
  VALUES ('{name}')
  ";

  case CreateRelationEmployedTraining = "
  INSERT INTO tbl_funcionario_treinamento
  (id_funcionario, id_profissao, id_treinamento)
  VALUES ({employed_id}, {job_id}, {training_id})
  ";

  case CreateRelationJobTraining = "
  INSERT INTO tbl_profissao_treinamento
  (id_profissao, id_treinamento)
  VALUES ({job_id}, {training_id})
  ";

  case SelectEmployedForEdit = "
  SELECT
  ft.id_funcionario AS employed_id
  FROM tbl_funcionario_treinamento AS ft
  WHERE ft.id_profissao='{job_id}'
  GROUP BY ft.id_funcionario
  ";

  case UpdateEmployed = "
  UPDATE tbl_funcionario
  SET
  nome='{name}',
  matricula='{mat}',
  telefone='{tel}',
  email='{email}'
  WHERE id='{id}'
  ";

  case UpdateEmployedWithJob = "
  UPDATE tbl_funcionario
  SET
  nome='{name}',
  matricula='{mat}',
  id_profissao='{id_job}',
  telefone='{tel}',
  email='{email}'
  WHERE id='{id}'
  ";

  case UpdateJob = "
  UPDATE tbl_profissao
  SET nome='{name}'
  WHERE id='{id}'
  ";

  case UpdateTraining = "
  UPDATE tbl_treinamento
  SET nome='{name}'
  WHERE id={id}
  ";

  case DeleteEmployedTraining = "
  DELETE FROM tbl_funcionario_treinamento
  WHERE id_funcionario={id}
  ";

  case DeleteRelationJobTraining = "
  DELETE FROM tbl_profissao_treinamento
  WHERE id_profissao='{job_id}'
  AND id_treinamento='{training_id}'
  ";

  case DeleteRelationEmployedTraining = "
  DELETE FROM tbl_funcionario_treinamento
  WHERE id_profissao='{job_id}' 
  AND id_treinamento='{training_id}'
  ";

  case Delete = "
  DELETE FROM {target} WHERE id={id}
  ";


  public function match(?array $values): string
  {
    $keys = array_keys($values);
    $code = $this->value;
    foreach ($keys as $key) {
      $pattern = "/\{{$key}\}/";
      if (preg_match($pattern, $this->value) != false) {
        $code = preg_replace($pattern, $values[$key], $code);
      } else {
        throw new InvalidModelArgument(
          "{$key} nao esta no codigo sql."
        );
      }
    }
    return $code;
  }
}
