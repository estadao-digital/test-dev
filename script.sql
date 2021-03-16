CREATE DATABASE IF NOT EXISTS SLICEIT;
USE SLICEIT;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `CARROS` (
 `ID` int(11) NOT NULL,
 `MARCA` int(50) NOT NULL,
 `MODELO` varchar(100) NOT NULL,
 `ANO` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CARROS`
--

INSERT INTO `CARROS` (`ID`, `MARCA`, `MODELO`, `ANO`) VALUES
(5, 6, 'Novo Onix', '2020'),
(6, 4, 'Uno Mile Fire ', '2018'),
(7, 5, 'Fiesta Hatch', '2008'),
(8, 18, 'Fusca', '1980');

-- --------------------------------------------------------

--
-- Table structure for table `MARCA`
--

CREATE TABLE `MARCA` (
 `ID` int(11) NOT NULL,
 `DESCRICAO` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `MARCA`
--

INSERT INTO `MARCA` (`ID`, `DESCRICAO`) VALUES
(1, 'Audi'),
(2, 'BMW'),
(3, 'Citroën'),
(4, 'Fiat'),
(5, 'Ford'),
(6, 'GM - Chevrolet'),
(7, 'Honda'),
(8, 'Hyundai'),
(9, 'Kia Motors'),
(10, 'Mercedes-Benz'),
(11, 'Mitsubishi'),
(12, 'Nissan'),
(13, 'Peugeot'),
(14, 'Renault'),
(15, 'Suzuki'),
(16, 'Toyota'),
(17, 'Volvo'),
(18, 'VW - VolksWagen'),
(19, 'Acura'),
(20, 'Agrale'),
(21, 'Alfa Romeo'),
(22, 'AM Gen'),
(23, 'Asia Motors'),
(24, 'ASTON MARTIN'),
(25, 'Baby'),
(26, 'BRM'),
(27, 'Bugre'),
(28, 'Cadillac'),
(29, 'CBT Jipe'),
(30, 'CHANA'),
(31, 'CHANGAN'),
(32, 'CHERY'),
(33, 'Chrysler'),
(34, 'Cross Lander'),
(35, 'Daewoo'),
(36, 'Daihatsu'),
(37, 'Dodge'),
(38, 'EFFA'),
(39, 'Engesa'),
(40, 'Envemo'),
(41, 'Ferrari'),
(42, 'Fibravan'),
(43, 'FOTON'),
(44, 'Fyber'),
(45, 'GEELY'),
(46, 'GREAT WALL'),
(47, 'Gurgel'),
(48, 'HAFEI'),
(49, 'HITECH ELECTRIC'),
(50, 'Isuzu'),
(51, 'IVECO'),
(52, 'JAC'),
(53, 'Jaguar'),
(54, 'Jeep'),
(55, 'JINBEI'),
(56, 'JPX'),
(57, 'Lada'),
(58, 'LAMBORGHINI'),
(59, 'Land Rover'),
(60, 'Lexus'),
(61, 'LIFAN'),
(62, 'LOBINI'),
(63, 'Lotus'),
(64, 'Mahindra'),
(65, 'Maserati'),
(66, 'Matra'),
(67, 'Mazda'),
(68, 'Mclaren'),
(69, 'Mercury'),
(70, 'MG'),
(71, 'MINI'),
(72, 'Miura'),
(73, 'Plymouth'),
(74, 'Pontiac'),
(75, 'Porsche'),
(76, 'RAM'),
(77, 'RELY'),
(78, 'Rolls-Royce'),
(79, 'Rover'),
(80, 'Saab'),
(81, 'Saturn'),
(82, 'Seat'),
(83, 'SHINERAY'),
(84, 'smart'),
(85, 'SSANGYONG'),
(86, 'Subaru'),
(87, 'TAC'),
(88, 'Troller'),
(89, 'Wake'),
(90, 'Walk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CARROS`
--
ALTER TABLE `CARROS`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `MARCA`
--
ALTER TABLE `MARCA`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CARROS`
--
ALTER TABLE `CARROS`
 MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `MARCA`
--
ALTER TABLE `MARCA`
 MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
COMMIT;
