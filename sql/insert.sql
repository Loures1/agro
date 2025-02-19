USE agro;

INSERT INTO `tbl_supervisor` (nome, cpf, email, telefone, senha)
VALUES
    ('João Silva', '529.982.247-25', 'joao.silva@gmail.com', '11987654321', 'senha123'),
    ('Maria Oliveira', '123.456.789-09', 'maria.oliveira@gmail.com', '21912345678', 'maria456'),
    ('Carlos Souza', '987.654.321-00', 'carlos.souza@gmail.com', '31998765432', 'carlos789'),
    ('Ana Costa', '111.222.333-96', 'ana.costa@gmail.com', '41987654321', 'ana101112'),
    ('Pedro Santos', '222.333.444-87', 'pedro.santos@gmail.com', '51912345678', 'pedro131415'),
    ('Fernanda Lima', '333.444.555-68', 'fernanda.lima@gmail.com', '61998765432', 'fernanda161718'),
    ('Ricardo Alves', '444.555.666-79', 'ricardo.alves@gmail.com', '71987654321', 'ricardo192021'),
    ('Juliana Pereira', '555.666.777-80', 'juliana.pereira@gmail.com', '81912345678', 'juliana222324'),
    ('Lucas Mendes', '666.777.888-91', 'lucas.mendes@gmail.com', '91998765432', 'lucas252627'),
    ('Patrícia Rocha', '777.888.999-02', 'patricia.rocha@gmail.com', '11912345678', 'patricia282930'),
    ('Roberto Almeida', '888.999.000-13', 'roberto.almeida@gmail.com', '11987654322', 'roberto123'),
    ('Camila Fernandes', '999.000.111-24', 'camila.fernandes@gmail.com', '21912345679', 'camila456'),
    ('Gustavo Henrique', '000.111.222-35', 'gustavo.henrique@gmail.com', '31998765433', 'gustavo789'),
    ('Isabela Santos', '111.222.333-46', 'isabela.santos@gmail.com', '41987654322', 'isabela101112'),
    ('Rafael Pereira', '222.333.444-57', 'rafael.pereira@gmail.com', '51912345679', 'rafael131415');

INSERT INTO `tbl_profissao` (nome)
VALUES
    ('Operador de Máquinas'),
    ('Técnico de Laboratório'),
    ('Engenheiro de Alimentos'),
    ('Supervisor de Produção'),
    ('Auxiliar de Limpeza'),
    ('Responsável Técnico'),
    ('Analista de Qualidade'),
    ('Encarregado de Logística'),
    ('Técnico de Manutenção'),
    ('Operador de Processos'),
    ('Auxiliar de Produção'),
    ('Gerente de Produção'),
    ('Nutricionista Industrial'),
    ('Coordenador de Segurança'),
    ('Operador de Caldeira'),
    ('Eletricista Industrial'),
    ('Operador de Empacotamento'),
    ('Conferente de Estoque'),
    ('Supervisor de Qualidade'),
    ('Assistente de RH'),
    ('Operador de Câmaras Frias'),
    ('Eletricista de Manutenção');

INSERT INTO `tbl_treinamento` (nome) 
VALUES
    ('Segurança em Máquinas Industriais'),
    ('Boas Práticas de Fabricação (BPF)'),
    ('Controle de Qualidade em Alimentos'),
    ('Gestão de Equipes'),
    ('Manutenção Preventiva Industrial'),
    ('Legislação Sanitária'),
    ('Análise Microbiológica'),
    ('Logística de Produção'),
    ('Higienização Industrial'),
    ('ISO 22000 - Segurança de Alimentos'),
    ('Operação de Empacotamento Automatizado'),
    ('Gestão de Resíduos Industriais'),
    ('Tecnologia de Processamento de Frutas'),
    ('Segurança Química'),
    ('Gestão de Projetos Industriais'),
    ('Calibração de Equipamentos'),
    ('Eletricidade Industrial Básica'),
    ('Auditoria Interna de Qualidade'),
    ('Primeiros Socorros Industrial'),
    ('Gestão de Fornecedores');

INSERT INTO `tbl_profissao_treinamento` (id_profissao, id_treinamento) 
VALUES
-- Operador de Máquinas (id 1)
    (1, 1),  -- Segurança em Máquinas Industriais
    (1, 2),  -- Boas Práticas de Fabricação (BPF)
    (1, 4),  -- Gestão de Equipes (se aplicável)
    (1, 12), -- Gestão de Resíduos Industriais

-- Técnico de Laboratório (id 2)
    (2, 2),  -- Boas Práticas de Fabricação (BPF)
    (2, 3),  -- Controle de Qualidade em Alimentos
    (2, 6),  -- Legislação Sanitária
    (2, 7),  -- Análise Microbiológica

-- Engenheiro de Alimentos (id 3)
    (3, 3),  -- Controle de Qualidade em Alimentos
    (3, 6),  -- Legislação Sanitária
    (3, 10), -- ISO 22000 - Segurança de Alimentos
    (3, 13), -- Tecnologia de Processamento de Frutas

-- Supervisor de Produção (id 4)
    (4, 4),  -- Gestão de Equipes
    (4, 8),  -- Logística de Produção
    (4, 14), -- Segurança Química
    (4, 15), -- Gestão de Projetos Industriais

-- Auxiliar de Limpeza (id 5)
    (5, 2),  -- Boas Práticas de Fabricação (BPF)
    (5, 9),  -- Higienização Industrial
    (5, 12), -- Gestão de Resíduos Industriais

-- Responsável Técnico (id 6)
    (6, 6),  -- Legislação Sanitária
    (6, 10), -- ISO 22000 - Segurança de Alimentos
    (6, 18), -- Auditoria Interna de Qualidade
    (6, 20), -- Gestão de Fornecedores

-- Analista de Qualidade (id 7)
    (7, 3),  -- Controle de Qualidade em Alimentos
    (7, 7),  -- Análise Microbiológica
    (7, 16), -- Calibração de Equipamentos
    (7, 18), -- Auditoria Interna de Qualidade

-- Encarregado de Logística (id 8)
    (8, 8),  -- Logística de Produção
    (8, 12), -- Gestão de Resíduos Industriais
    (8, 20), -- Gestão de Fornecedores

-- Técnico de Manutenção (id 9)
    (9, 5),  -- Manutenção Preventiva Industrial
    (9, 17), -- Eletricidade Industrial Básica
    (9, 14), -- Segurança Química

-- Operador de Processos (id 10)
    (10, 1), -- Segurança em Máquinas Industriais
    (10, 11),-- Operação de Empacotamento Automatizado
    (10, 13),-- Tecnologia de Processamento de Frutas

-- Auxiliar de Produção (id 11)
    (11, 2), -- Boas Práticas de Fabricação (BPF)
    (11, 9), -- Higienização Industrial
    (11, 19),-- Primeiros Socorros Industrial

-- Gerente de Produção (id 12)
    (12, 4), -- Gestão de Equipes
    (12, 8), -- Logística de Produção
    (12, 15),-- Gestão de Projetos Industriais
    (12, 20),-- Gestão de Fornecedores

-- Nutricionista Industrial (id 13)
    (13, 3), -- Controle de Qualidade em Alimentos
    (13, 6), -- Legislação Sanitária
    (13, 10),-- ISO 22000 - Segurança de Alimentos

-- Coordenador de Segurança (id 14)
    (14, 1), -- Segurança em Máquinas Industriais
    (14, 14),-- Segurança Química
    (14, 19),-- Primeiros Socorros Industrial

-- Operador de Caldeira (id 15)
    (15, 1), -- Segurança em Máquinas Industriais
    (15, 5), -- Manutenção Preventiva Industrial
    (15, 14),-- Segurança Química

-- Eletricista Industrial (id 16)
    (16, 17),-- Eletricidade Industrial Básica
    (16, 5), -- Manutenção Preventiva Industrial
    (16, 14),-- Segurança Química

-- Operador de Empacotamento (id 17)
    (17, 11),-- Operação de Empacotamento Automatizado
    (17, 2), -- Boas Práticas de Fabricação (BPF)
    (17, 9), -- Higienização Industrial

-- Conferente de Estoque (id 18)
    (18, 8), -- Logística de Produção
    (18, 12),-- Gestão de Resíduos Industriais
    (18, 20),-- Gestão de Fornecedores

-- Supervisor de Qualidade (id 19)
    (19, 3), -- Controle de Qualidade em Alimentos
    (19, 6), -- Legislação Sanitária
    (19, 18),-- Auditoria Interna de Qualidade

-- Assistente de RH (id 20)
    (20, 4), -- Gestão de Equipes
    (20, 15),-- Gestão de Projetos Industriais
    (20, 19);-- Primeiros Socorros Industrial

INSERT INTO `tbl_funcionario` (nome, id_profissao, telefone, email) VALUES
('João Silva', 1, '(11) 98765-4321', 'joao.silva@empresa.com'),          -- Operador de Máquinas
('Maria Oliveira', 2, '(21) 99876-5432', 'maria.oliveira@empresa.com'),  -- Técnico de Laboratório
('Carlos Souza', 3, '(31) 91234-5678', 'carlos.souza@empresa.com'),      -- Engenheiro de Alimentos
('Ana Costa', 4, '(41) 92345-6789', 'ana.costa@empresa.com'),            -- Supervisor de Produção
('Pedro Rocha', 5, '(51) 93456-7890', 'pedro.rocha@empresa.com'),        -- Auxiliar de Limpeza
('Fernanda Lima', 6, '(61) 94567-8901', 'fernanda.lima@empresa.com'),    -- Responsável Técnico
('Lucas Santos', 7, '(71) 95678-9012', 'lucas.santos@empresa.com'),      -- Analista de Qualidade
('Juliana Alves', 8, '(81) 96789-0123', 'juliana.alves@empresa.com'),    -- Encarregado de Logística
('Rafael Pereira', 9, '(85) 97890-1234', 'rafael.pereira@empresa.com'),  -- Técnico de Manutenção
('Patrícia Mendes', 10, '(92) 98901-2345', 'patricia.mendes@empresa.com'),-- Operador de Processos
('Marcos Torres', 11, '(95) 99012-3456', 'marcos.torres@empresa.com'),   -- Auxiliar de Produção
('Camila Ribeiro', 12, '(98) 90123-4567', 'camila.ribeiro@empresa.com'), -- Gerente de Produção
('Gustavo Nunes', 13, '(99) 91234-5678', 'gustavo.nunes@empresa.com'),   -- Nutricionista Industrial
('Beatriz Castro', 14, '(84) 92345-6789', 'beatriz.castro@empresa.com'), -- Coordenador de Segurança
('Diego Fernandes', 15, '(79) 93456-7890', 'diego.fernandes@empresa.com'),-- Operador de Caldeira
('Laura Martins', 16, '(67) 94567-8901', 'laura.martins@empresa.com'),   -- Eletricista Industrial
('Thiago Gomes', 17, '(63) 95678-9012', 'thiago.gomes@empresa.com'),     -- Operador de Empacotamento
('Amanda Duarte', 18, '(69) 96789-0123', 'amanda.duarte@empresa.com'),  -- Conferente de Estoque
('Bruno Carvalho', 19, '(96) 97890-1234', 'bruno.carvalho@empresa.com'), -- Supervisor de Qualidade
('Isabela Freitas', 20, '(91) 98901-2345', 'isabela.freitas@empresa.com');-- Assistente de RH

-- Funcionário 1 (João Silva - Operador de Máquinas)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(1, 1), -- Segurança em Máquinas Industriais
(1, 2); -- Boas Práticas de Fabricação (BPF)

-- Funcionária 2 (Maria Oliveira - Técnico de Laboratório)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(2, 2), -- Boas Práticas de Fabricação (BPF)
(2, 7); -- Análise Microbiológica

-- Funcionário 3 (Carlos Souza - Engenheiro de Alimentos)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(3, 3), -- Controle de Qualidade em Alimentos
(3, 6); -- Legislação Sanitária

-- Funcionária 4 (Ana Costa - Supervisor de Produção)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(4, 4), -- Gestão de Equipes
(4, 8); -- Logística de Produção

-- Funcionário 5 (Pedro Rocha - Auxiliar de Limpeza)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(5, 9), -- Higienização Industrial
(5, 12); -- Gestão de Resíduos Industriais

-- Funcionária 6 (Fernanda Lima - Responsável Técnico)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(6, 6), -- Legislação Sanitária
(6, 10); -- ISO 22000

-- Funcionário 7 (Lucas Santos - Analista de Qualidade)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(7, 3), -- Controle de Qualidade em Alimentos
(7, 7); -- Análise Microbiológica

-- Funcionária 8 (Juliana Alves - Encarregado de Logística)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(8, 8); -- Logística de Produção

-- Funcionário 9 (Rafael Pereira - Técnico de Manutenção)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(9, 5); -- Manutenção Preventiva Industrial

-- Funcionária 10 (Patrícia Mendes - Operador de Processos)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(10, 1); -- Segurança em Máquinas Industriais

-- Funcionário 16 (Laura Martins - Eletricista Industrial)
INSERT INTO `tbl_funcionario_treinamento` (id_funcionario, id_treinamento) VALUES
(16, 17); -- Eletricidade Industrial Básica
