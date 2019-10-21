-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Out-2019 às 04:03
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
  `id_marca` int(10) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_carros`
--

INSERT INTO `tb_carros` (`id`, `id_marca`, `modelo`, `ano`) VALUES
(1, 1, 'Fusion', 2015),
(2, 1, 'Fiesta', 2012),
(3, 2, 'Polo', 2011),
(4, 2, 'Uno', 2013),
(6, 3, 'Fit', 2010),
(7, 8, 'Corola', 2019);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_marcas`
--

CREATE TABLE `tb_marcas` (
  `id_marca` int(11) NOT NULL,
  `marca` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_marcas`
--

INSERT INTO `tb_marcas` (`id_marca`, `marca`) VALUES
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
  ADD PRIMARY KEY (`id_marca`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_carros`
--
ALTER TABLE `tb_carros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tb_marcas`
--
ALTER TABLE `tb_marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
