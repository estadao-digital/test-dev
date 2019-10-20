-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Out-2019 às 04:31
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_test-dev`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_carros`
--

CREATE TABLE `tb_carros` (
  `id` int(11) NOT NULL,
  `marca` int(11) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_carros`
--

INSERT INTO `tb_carros` (`id`, `marca`, `modelo`, `ano`) VALUES
(1, 1, 'Argo', 2012),
(3, 1, 'Argo', 2014),
(4, 3, 'Gol', 2019),
(5, 4, 'Corsa', 2008),
(6, 3, 'Golf', 2013),
(7, 9, 'Fusion', 2017),
(8, 9, 'Fiesta', 2014),
(9, 1, 'Argo', 2019),
(10, 2, 'Kicks', 2019),
(11, 4, 'Marajó', 1985),
(12, 1, 'Toro', 2018),
(13, 1, 'Toro', 2015);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_marcas`
--

CREATE TABLE `tb_marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_marcas`
--

INSERT INTO `tb_marcas` (`id`, `marca`) VALUES
(1, 'Fiat'),
(2, 'Nissam'),
(3, 'Wolksvagem'),
(4, 'Chevrolet'),
(5, 'Honda'),
(6, 'Toyota'),
(7, 'Subaru'),
(8, 'Hyundai'),
(9, 'Ford');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_carros`
--
ALTER TABLE `tb_carros`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_marcas`
--
ALTER TABLE `tb_marcas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_carros`
--
ALTER TABLE `tb_carros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `tb_marcas`
--
ALTER TABLE `tb_marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
