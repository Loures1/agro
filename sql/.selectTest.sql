SELECT t.nome, ft.ativo
FROM tbl_treinamento AS t
INNER JOIN
(
  SELECT c.id_treinamento,
  CASE
    WHEN ft.id_treinamento IS null THEN 0
    ELSE 1
  END ativo
  FROM tbl_funcionario_treinamento AS ft
  RIGHT JOIN
  (
    SELECT f.id AS id_funcionario, pt.id_treinamento
    FROM tbl_funcionario AS f
    CROSS JOIN tbl_profissao_treinamento AS pt
    ON f.id_profissao = pt.id_profissao
    WHERE f.id = 1
  ) AS c
  ON ft.id_treinamento = c.id_treinamento
  AND ft.id_funcionario = c.id_funcionario
) AS ft
ON t.id = ft.id_treinamento
ORDER BY ativo;
