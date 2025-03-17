<?php

use app\classes\Query;

require 'bootstrap.php';

function assertRelationDataBase(
    ?string $employed, 
    ?string $job, 
    ?string $training)
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
        $t = new Query();
        $return = $t->execQuery($code);
        $return = ($return->fetch_row()[0] == true) ?: false;
        return $return;
    }

echo assertRelationDataBase('Joao Silva', 'Operador de Maquinas', 'Gestao de Equipes');

function assertDataBase(?string $value, ?string $target): bool
{
  $code = <<<EOT
    SELECT EXISTS(SELECT * FROM $target AS t WHERE t.nome = '$value')
  EOT;
  $t = new Query;
  $return = $t->execQuery($code);
  $return = ($return->fetch_row()[0] == true) ?: false;
  return $return;
}

echo assertDataBase('Joao Silva', 'tbl_funcionario');