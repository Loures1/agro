USE agro;

INSERT INTO `tbl_supervisor` (nome, cpf, email, telefone, senha)
VALUES
    ('Joao Silva', '529.982.247-25', 'joao.silva@gmail.com', '11987654321', 'senha123'),
    ('Maria Oliveira', '123.456.789-09', 'maria.oliveira@gmail.com', '21912345678', 'maria456'),
    ('Carlos Souza', '987.654.321-00', 'carlos.souza@gmail.com', '31998765432', 'carlos789'),
    ('Ana Costa', '111.222.333-96', 'ana.costa@gmail.com', '41987654321', 'ana101112'),
    ('Pedro Santos', '222.333.444-87', 'pedro.santos@gmail.com', '51912345678', 'pedro131415'),
    ('Fernanda Lima', '333.444.555-68', 'fernanda.lima@gmail.com', '61998765432', 'fernanda161718'),
    ('Ricardo Alves', '444.555.666-79', 'ricardo.alves@gmail.com', '71987654321', 'ricardo192021'),
    ('Juliana Pereira', '555.666.777-80', 'juliana.pereira@gmail.com', '81912345678', 'juliana222324'),
    ('Lucas Mendes', '666.777.888-91', 'lucas.mendes@gmail.com', '91998765432', 'lucas252627'),
    ('Patricia Rocha', '777.888.999-02', 'patricia.rocha@gmail.com', '11912345678', 'patricia282930'),
    ('Roberto Almeida', '888.999.000-13', 'roberto.almeida@gmail.com', '11987654322', 'roberto123'),
    ('Camila Fernandes', '999.000.111-24', 'camila.fernandes@gmail.com', '21912345679', 'camila456'),
    ('Gustavo Henrique', '000.111.222-35', 'gustavo.henrique@gmail.com', '31998765433', 'gustavo789'),
    ('Isabela Santos', '111.222.333-46', 'isabela.santos@gmail.com', '41987654322', 'isabela101112'),
    ('Rafael Pereira', '222.333.444-57', 'rafael.pereira@gmail.com', '51912345679', 'rafael131415');

INSERT INTO `tbl_profissao` (nome)
VALUES
    ('Operador de Maquinas'),
    ('Tecnico de Laboratorio'),
    ('Engenheiro de Alimentos'),
    ('Supervisor de Producao'),
    ('Auxiliar de Limpeza'),
    ('Responsavel Tecnico'),
    ('Analista de Qualidade'),
    ('Encarregado de Logistica'),
    ('Tecnico de Manutencao'),
    ('Operador de Processos'),
    ('Auxiliar de Producao'),
    ('Gerente de Producao'),
    ('Nutricionista Industrial'),
    ('Coordenador de Seguranca'),
    ('Operador de Caldeira'),
    ('Eletricista Industrial'),
    ('Operador de Empacotamento'),
    ('Conferente de Estoque'),
    ('Supervisor de Qualidade'),
    ('Assistente de RH'),
    ('Operador de Camaras Frias'),
    ('Eletricista de Manutencao');

INSERT INTO `tbl_treinamento` (nome) 
VALUES
    ('Seguranca em Maquinas Industriais'),
    ('Boas Praticas de Fabricacao (BPF)'),
    ('Controle de Qualidade em Alimentos'),
    ('Gestao de Equipes'),
    ('Manutencao Preventiva Industrial'),
    ('Legislacao Sanitaria'),
    ('Analise Microbiologica'),
    ('Logistica de Producao'),
    ('Higienizacao Industrial'),
    ('ISO 22000 - Seguranca de Alimentos'),
    ('Operacao de Empacotamento Automatizado'),
    ('Gestao de Residuos Industriais'),
    ('Tecnologia de Processamento de Frutas'),
    ('Seguranca Quimica'),
    ('Gestao de Projetos Industriais'),
    ('Calibracao de Equipamentos'),
    ('Eletricidade Industrial Basica'),
    ('Auditoria Interna de Qualidade'),
    ('Primeiros Socorros Industrial'),
    ('Gestao de Fornecedores');

INSERT INTO `tbl_profissao_treinamento` (id_profissao, id_treinamento) 
VALUES
    (1, 1), (1, 2), (1, 4), (1, 12),
    (2, 2), (2, 3), (2, 6), (2, 7),
    (3, 3), (3, 6), (3, 10), (3, 13),
    (4, 4), (4, 8), (4, 14), (4, 15),
    (5, 2), (5, 9), (5, 12),
    (6, 6), (6, 10), (6, 18), (6, 20),
    (7, 3), (7, 7), (7, 16), (7, 18),
    (8, 8), (8, 12), (8, 20),
    (9, 5), (9, 17), (9, 14),
    (10, 1), (10, 11), (10, 13),
    (11, 2), (11, 9), (11, 19),
    (12, 4), (12, 8), (12, 15), (12, 20),
    (13, 3), (13, 6), (13, 10),
    (14, 1), (14, 14), (14, 19),
    (15, 1), (15, 5), (15, 14),
    (16, 17), (16, 5), (16, 14),
    (17, 11), (17, 2), (17, 9),
    (18, 8), (18, 12), (18, 20),
    (19, 3), (19, 6), (19, 18),
    (20, 4), (20, 15), (20, 19);

INSERT INTO tbl_funcionario (matricula, nome, id_profissao, telefone, email) VALUES
('MAT001', 'Joao Silva', 1, '(11) 98765-4321', 'joao.silva@empresa.com'),
('MAT002', 'Maria Oliveira', 2, '(21) 99876-5432', 'maria.oliveira@empresa.com'),
('MAT003', 'Carlos Souza', 3, '(31) 91234-5678', 'carlos.souza@empresa.com'),
('MAT004', 'Ana Costa', 4, '(41) 92345-6789', 'ana.costa@empresa.com'),
('MAT005', 'Pedro Rocha', 5, '(51) 93456-7890', 'pedro.rocha@empresa.com'),
('MAT006', 'Fernanda Lima', 6, '(61) 94567-8901', 'fernanda.lima@empresa.com'),
('MAT007', 'Lucas Santos', 7, '(71) 95678-9012', 'lucas.santos@empresa.com'),
('MAT008', 'Juliana Alves', 8, '(81) 96789-0123', 'juliana.alves@empresa.com'),
('MAT009', 'Rafael Pereira', 9, '(85) 97890-1234', 'rafael.pereira@empresa.com'),
('MAT010', 'Patricia Mendes', 10, '(92) 98901-2345', 'patricia.mendes@empresa.com'),
('MAT011', 'Marcos Torres', 11, '(95) 99012-3456', 'marcos.torres@empresa.com'),
('MAT012', 'Camila Ribeiro', 12, '(98) 90123-4567', 'camila.ribeiro@empresa.com'),
('MAT013', 'Gustavo Nunes', 13, '(99) 91234-5678', 'gustavo.nunes@empresa.com'),
('MAT014', 'Beatriz Castro', 14, '(84) 92345-6789', 'beatriz.castro@empresa.com'),
('MAT015', 'Diego Fernandes', 15, '(79) 93456-7890', 'diego.fernandes@empresa.com'),
('MAT016', 'Laura Martins', 16, '(67) 94567-8901', 'laura.martins@empresa.com'),
('MAT017', 'Thiago Gomes', 17, '(63) 95678-9012', 'thiago.gomes@empresa.com'),
('MAT018', 'Amanda Duarte', 18, '(69) 96789-0123', 'amanda.duarte@empresa.com'),
('MAT019', 'Bruno Carvalho', 19, '(96) 97890-1234', 'bruno.carvalho@empresa.com'),
('MAT020', 'Isabela Freitas', 20, '(91) 98901-2345', 'isabela.freitas@empresa.com');

INSERT INTO tbl_funcionario_treinamento (id_funcionario, id_treinamento, status)
SELECT
    f.id AS id_funcionario,
    pt.id_treinamento,
    (SELECT floor(rand() * 2))
FROM tbl_funcionario AS f
JOIN tbl_profissao_treinamento AS pt ON f.id_profissao = pt.id_profissao;

UPDATE tbl_funcionario_treinamento
SET data_vencimento = (
    SELECT
    CASE
        WHEN (SELECT FLOOR(RAND()*2)) LIKE 1 THEN 
            (SELECT ADDDATE(CURDATE(), INTERVAL FLOOR(RAND() * 365 * 3) DAY))
        ELSE 
            (SELECT ADDDATE(CURDATE(), INTERVAL FLOOR(RAND() * -120) DAY))
    END
)
WHERE status=1;
