-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 23/05/2026 às 22:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fluxo_restaurante`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comandas`
--

CREATE TABLE `comandas` (
  `id` int(11) NOT NULL,
  `mesa` int(11) NOT NULL,
  `itens` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`itens`)),
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comandas_fechadas`
--

CREATE TABLE `comandas_fechadas` (
  `id` int(11) NOT NULL,
  `mesa` int(11) NOT NULL,
  `itens` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`itens`)),
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `especialidade` enum('garcom','cozinha','gerente','admin') NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `usuario`, `especialidade`, `senha`, `created_at`) VALUES
(4, 'Root Garcom', 'root.garcom', 'garcom', '$2y$10$ALuSYzIdOo6kgxVJOimpkuMBEfRULFDp5puHJWk/1iEU25snYH7cS', '2026-05-23 20:02:36'),
(5, 'Root Cozinha', 'root.cozinha', 'cozinha', '$2y$10$VYhZaiHbK5qvjfNLep0Bi.yq8bzkxaZCOF.dhgGP9JqoWPlP7nuEq', '2026-05-23 20:02:36'),
(6, 'Root Gerente', 'root.gerente', 'gerente', '$2y$10$yNJyO0/U8OMi1GLtSAIIS./EbhcPYghP/CPWDOlrzRuihJk6QL/kW', '2026-05-23 20:02:36'),
(7, 'Thiago Lima', 'thiago.lima', 'gerente', '$2y$10$bZpOY76IjQfaHoaucoxeCewNeq1BqrJ1ZQxDefJthpYRcUw0DJ3/W', '2026-05-23 20:02:57');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `cadeiras` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `numeroMesa` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aguardando',
  `itens` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`itens`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mesa` (`mesa`),
  ADD KEY `idx_mesa` (`mesa`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_mesa_created` (`mesa`,`created_at`);

--
-- Índices de tabela `comandas_fechadas`
--
ALTER TABLE `comandas_fechadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mesa` (`mesa`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_mesa_created` (`mesa`,`created_at`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Índices de tabela `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `comandas_fechadas`
--
ALTER TABLE `comandas_fechadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comandas`
--
ALTER TABLE `comandas`
  ADD CONSTRAINT `comandas_ibfk_1` FOREIGN KEY (`mesa`) REFERENCES `mesas` (`numero`) ON DELETE CASCADE;

--
-- Restrições para tabelas `comandas_fechadas`
--
ALTER TABLE `comandas_fechadas`
  ADD CONSTRAINT `comandas_fechadas_ibfk_1` FOREIGN KEY (`mesa`) REFERENCES `mesas` (`numero`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
