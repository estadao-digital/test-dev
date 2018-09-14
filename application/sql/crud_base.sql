-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 14-Set-2018 às 03:29
-- Versão do servidor: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_base`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabcarro`
--

CREATE TABLE `tabCarro` (
  `intId` int(11) NOT NULL,
  `intAno` int(11) DEFAULT NULL,
  `strModelo` varchar(45) NOT NULL,
  `strMarca` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabCarro`
--

INSERT INTO `tabCarro` (`intId`, `intAno`, `strModelo`, `strMarca`) VALUES
(3, 2009, 'Wolks', 'Gol'),
(12, 2010, 'Wolks', 'ojgojhijoisgjiosdg'),
(13, 2011, 'SE3', 'Volkswagen'),
(14, 2010, 'Wolks123', 'Honda');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabCarro`
--
ALTER TABLE `tabcarro`
  ADD PRIMARY KEY (`intId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabCarro`
--
ALTER TABLE `tabCarro`
  MODIFY `intId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
