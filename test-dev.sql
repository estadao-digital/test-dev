DROP DATABASE IF EXISTS `test-dev`;
CREATE DATABASE IF NOT EXISTS `test-dev`;
USE `test-dev`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `test-dev`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carros`
--

CREATE TABLE `carros` (
  `id` int(10) UNSIGNED NOT NULL,
  `marca_id` int(10) UNSIGNED NOT NULL,
  `modelo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ano` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE `marcas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`id`, `nome`) VALUES
(1, 'Chevrolet'),
(2, 'Volkswagen'),
(3, 'Peugeout'),
(4, 'Fiat'),
(5, 'Audi'),
(6, 'Ford'),
(7, 'Citroen'),
(8, 'Ferrari'),
(9, 'Hyundai'),
(10, 'Honda'),
(11, 'BMW'),
(12, 'Toyota'),
(13, 'Kia'),
(14, 'Mazda'),
(15, 'Nissan'),
(16, 'Porsche'),
(17, 'Suzuki'),
(18, 'Renault'),
(19, 'Land Rover'),
(20, 'Subaru'),
(21, 'Lexus'),
(22, 'Mitsubishi'),
(23, 'Volvo'),
(24, 'Jeep'),
(25, 'Bentley');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carros`
--
ALTER TABLE `carros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carros_marca_id_foreign` (`marca_id`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carros`
--
ALTER TABLE `carros`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `carros`
--
ALTER TABLE `carros`
  ADD CONSTRAINT `carros_marca_id_foreign` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`);
COMMIT;
