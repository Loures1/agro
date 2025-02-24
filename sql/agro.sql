-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Dez-2024 às 15:25
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_funcionario`
--
--
--
USE agro;

CREATE TABLE `tbl_funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `matricula` varchar(255) NOT NULL,
  `id_profissao` int(11) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_funcionario_profissao_treinamento`
--

CREATE TABLE `tbl_funcionario_treinamento` (
  `id` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_treinamento` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `data_vencimento` date NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_profissao`
--

CREATE TABLE `tbl_profissao` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_profissao_treinamento`
--

CREATE TABLE `tbl_profissao_treinamento` (
  `id` int(11) NOT NULL,
  `id_profissao` int(11) NOT NULL,
  `id_treinamento` int(11) NOT NULL,
  `data_vencimento` date NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_supervisor`
--

CREATE TABLE `tbl_supervisor` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbl_supervisor`
--
-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_treinamento`
--

CREATE TABLE `tbl_treinamento` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tbl_funcionario`
--
ALTER TABLE `tbl_funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `tbl_funcionario_profissao_treinamento`
--
ALTER TABLE `tbl_funcionario_treinamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `id_treinamento` (`id_treinamento`);

--
-- Índices para tabela `tbl_profissao`
--
ALTER TABLE `tbl_profissao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `tbl_profissao_treinamento`
--
ALTER TABLE `tbl_profissao_treinamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_profissao` (`id_profissao`),
  ADD KEY `id_treinamento` (`id_treinamento`);

--
-- Índices para tabela `tbl_supervisor`
--
ALTER TABLE `tbl_supervisor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `tbl_treinamento`
--
ALTER TABLE `tbl_treinamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_funcionario`
--
ALTER TABLE `tbl_funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_funcionario_profissao_treinamento`
--
ALTER TABLE `tbl_funcionario_treinamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_profissao`
--
ALTER TABLE `tbl_profissao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_profissao_treinamento`
--
ALTER TABLE `tbl_profissao_treinamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_supervisor`
--
ALTER TABLE `tbl_supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_treinamento`
--
ALTER TABLE `tbl_treinamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tbl_funcionario_profissao_treinamento`
--
ALTER TABLE `tbl_funcionario_treinamento`
  ADD CONSTRAINT `tbl_funcionario_treinamento_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_funcionario_treinamento_ibfk_2` FOREIGN KEY (`id_treinamento`) REFERENCES `tbl_treinamento` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tbl_profissao_treinamento`
--
ALTER TABLE `tbl_profissao_treinamento`
  ADD CONSTRAINT `tbl_profissao_treinamento_ibfk_1` FOREIGN KEY (`id_profissao`) REFERENCES `tbl_profissao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_profissao_treinamento_ibfk_2` FOREIGN KEY (`id_treinamento`) REFERENCES `tbl_treinamento` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
