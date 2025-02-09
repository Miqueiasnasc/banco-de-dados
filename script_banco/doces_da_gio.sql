-- Criando o banco de dados
CREATE DATABASE IF NOT EXISTS doces_da_gio;
USE doces_da_gio;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 04:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doces_da_gio`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AlterarParaAdmin` (IN `userId` INT)   BEGIN
    UPDATE users
    SET tipo = 'admin'
    WHERE id = userId;
END$$


CREATE DEFINER=`root`@`localhost` PROCEDURE `ObterContato` (IN `id_user` INT)   BEGIN
    SELECT * FROM tb_contato WHERE fk_id_user = id_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObterEndereco` (IN `id_user` INT)   BEGIN
    SELECT * FROM tb_endereco WHERE fk_id_user = id_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PreencherContato` ()   BEGIN
    INSERT INTO tb_contato (telefone, email, fk_id_user)
    SELECT telefone, email, id
    FROM users
    WHERE id NOT IN (SELECT fk_id_user FROM tb_contato);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PreencherEndereco` ()   BEGIN
    INSERT INTO tb_endereco (endereco, fk_id_user)
    SELECT endereco, id
    FROM users
    WHERE id NOT IN (SELECT fk_id_user FROM tb_endereco);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_contato`
--

CREATE TABLE `tb_contato` (
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fk_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_doceria`
--

CREATE TABLE `tb_doceria` (
  `pk_cnpj` varchar(20) NOT NULL,
  `nome` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_endereco`
--

CREATE TABLE `tb_endereco` (
  `endereco` varchar(255) DEFAULT NULL,
  `fk_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_endereco_doceria`
--

CREATE TABLE `tb_endereco_doceria` (
  `pk_cep` varchar(10) NOT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `bairro` varchar(60) DEFAULT NULL,
  `numero` decimal(10,0) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `cidade` varchar(60) DEFAULT NULL,
  `fk_cnpj` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_funcionarios`
--

CREATE TABLE `tb_funcionarios` (
  `pk_id_funcionario` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `funcao` varchar(60) DEFAULT NULL,
  `fk_cnpj` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_itens_pedidos`
--

CREATE TABLE `tb_itens_pedidos` (
  `pk_itens_pedidos` int(11) NOT NULL,
  `fk_id_user` int(11) DEFAULT NULL,
  `fk_id_produto` int(11) DEFAULT NULL,
  `fk_id_pedido` int(11) DEFAULT NULL,
  `subtotal_itens_pedidos` float DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_nota_fiscal`
--

CREATE TABLE `tb_nota_fiscal` (
  `pk_nota_fiscal` int(11) NOT NULL,
  `fk_itens_pedidos` int(11) DEFAULT NULL,
  `fk_cnpj` varchar(20) DEFAULT NULL,
  `fk_id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pedido`
--

CREATE TABLE `tb_pedido` (
  `pk_id_pedido` int(11) NOT NULL,
  `fk_id_user` int(11) DEFAULT NULL,
  `fk_cnpj` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_produto`
--

CREATE TABLE `tb_produto` (
  `pk_id_produto` int(11) NOT NULL,
  `nome_produto` varchar(60) DEFAULT NULL,
  `valor_produto` float DEFAULT NULL,
  `qntd_estoque_produto` decimal(10,0) DEFAULT NULL,
  `descricao_produto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` char(14) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `tipo` enum('admin','comum') DEFAULT 'comum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `senha`, `cpf`, `telefone`, `endereco`, `tipo`) VALUES
(1, 'MIQUEIAS SANTOS', 'miqueias@gmail.com', '12345', '553.477.890-34', '11965264365', 'Frutuoso Gomes São Paulo', 'comum'),
(2, 'adm', 'adm@gmail.com', '12345', '582.884.970-04', '119888445', 'rua dos adm', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_contato`
--
ALTER TABLE `tb_contato`
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indexes for table `tb_doceria`
--
ALTER TABLE `tb_doceria`
  ADD PRIMARY KEY (`pk_cnpj`);

--
-- Indexes for table `tb_endereco`
--
ALTER TABLE `tb_endereco`
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indexes for table `tb_endereco_doceria`
--
ALTER TABLE `tb_endereco_doceria`
  ADD PRIMARY KEY (`pk_cep`),
  ADD KEY `fk_cnpj` (`fk_cnpj`);

--
-- Indexes for table `tb_funcionarios`
--
ALTER TABLE `tb_funcionarios`
  ADD PRIMARY KEY (`pk_id_funcionario`),
  ADD KEY `fk_cnpj` (`fk_cnpj`);

--
-- Indexes for table `tb_itens_pedidos`
--
ALTER TABLE `tb_itens_pedidos`
  ADD PRIMARY KEY (`pk_itens_pedidos`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_produto` (`fk_id_produto`),
  ADD KEY `fk_id_pedido` (`fk_id_pedido`);

--
-- Indexes for table `tb_nota_fiscal`
--
ALTER TABLE `tb_nota_fiscal`
  ADD PRIMARY KEY (`pk_nota_fiscal`),
  ADD KEY `fk_itens_pedidos` (`fk_itens_pedidos`),
  ADD KEY `fk_cnpj` (`fk_cnpj`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indexes for table `tb_pedido`
--
ALTER TABLE `tb_pedido`
  ADD PRIMARY KEY (`pk_id_pedido`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_cnpj` (`fk_cnpj`);

--
-- Indexes for table `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`pk_id_produto`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_funcionarios`
--
ALTER TABLE `tb_funcionarios`
  MODIFY `pk_id_funcionario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_itens_pedidos`
--
ALTER TABLE `tb_itens_pedidos`
  MODIFY `pk_itens_pedidos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_nota_fiscal`
--
ALTER TABLE `tb_nota_fiscal`
  MODIFY `pk_nota_fiscal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pedido`
--
ALTER TABLE `tb_pedido`
  MODIFY `pk_id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `pk_id_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_contato`
--
ALTER TABLE `tb_contato`
  ADD CONSTRAINT `tb_contato_ibfk_1` FOREIGN KEY (`fk_id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_endereco`
--
ALTER TABLE `tb_endereco`
  ADD CONSTRAINT `tb_endereco_ibfk_1` FOREIGN KEY (`fk_id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_endereco_doceria`
--
ALTER TABLE `tb_endereco_doceria`
  ADD CONSTRAINT `tb_endereco_doceria_ibfk_1` FOREIGN KEY (`fk_cnpj`) REFERENCES `tb_doceria` (`pk_cnpj`);

--
-- Constraints for table `tb_funcionarios`
--
ALTER TABLE `tb_funcionarios`
  ADD CONSTRAINT `tb_funcionarios_ibfk_1` FOREIGN KEY (`fk_cnpj`) REFERENCES `tb_doceria` (`pk_cnpj`);

--
-- Constraints for table `tb_itens_pedidos`
--
ALTER TABLE `tb_itens_pedidos`
  ADD CONSTRAINT `tb_itens_pedidos_ibfk_1` FOREIGN KEY (`fk_id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tb_itens_pedidos_ibfk_2` FOREIGN KEY (`fk_id_produto`) REFERENCES `tb_produto` (`pk_id_produto`),
  ADD CONSTRAINT `tb_itens_pedidos_ibfk_3` FOREIGN KEY (`fk_id_pedido`) REFERENCES `tb_pedido` (`pk_id_pedido`);

--
-- Constraints for table `tb_nota_fiscal`
--
ALTER TABLE `tb_nota_fiscal`
  ADD CONSTRAINT `tb_nota_fiscal_ibfk_1` FOREIGN KEY (`fk_itens_pedidos`) REFERENCES `tb_itens_pedidos` (`pk_itens_pedidos`),
  ADD CONSTRAINT `tb_nota_fiscal_ibfk_2` FOREIGN KEY (`fk_cnpj`) REFERENCES `tb_doceria` (`pk_cnpj`),
  ADD CONSTRAINT `tb_nota_fiscal_ibfk_3` FOREIGN KEY (`fk_id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `tb_pedido`
--
ALTER TABLE `tb_pedido`
  ADD CONSTRAINT `tb_pedido_ibfk_1` FOREIGN KEY (`fk_id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tb_pedido_ibfk_2` FOREIGN KEY (`fk_cnpj`) REFERENCES `tb_doceria` (`pk_cnpj`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
