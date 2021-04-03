
DROP TABLE IF EXISTS `Carros`;
DROP TABLE IF EXISTS `Marcas`;
DROP TABLE IF EXISTS `Modelos`;


CREATE TABLE `Carros` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `placa` varchar(8) NOT NULL,
  `modelo_id` int(2) NOT NULL,
  `ano` int(4) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `Marcas` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nome` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `Modelos` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `marca_id` int(2) NOT NULL,
  `nome` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `Marcas` ( `id`, `nome`) VALUES 
  ('1', 'Chevrolet'), 
  ('2', 'Hyundai'), 
  ('3', 'Volkswagen'), 
  ('4', 'Ford'), 
  ('5', 'Fiat'), 
  ('6', 'Renault');


INSERT INTO `Modelos` (`marca_id`, `nome`) VALUES 
  ('1', 'Onix'), 
  ('1', 'Prisma'), 
  ('2', 'HB20'), 
  ('2', 'Creta'), 
  ('3', 'Gol'), 
  ('3', 'T-Cross'), 
  ('4', 'Ka'), 
  ('5', 'Argo'),
  ('6', 'Kwid'),
  ('5', 'Mobi'),
  ('3', 'Polo'),
  ('6', 'Sandero'),
  ('5', 'Uno'),
  ('5', 'Strada');


INSERT INTO `Carros` (`placa`, `modelo_id`, `ano`) VALUES
  ('AAA-0123', 1, 2020),
  ('AAB-1122', 1, 2018),
  ('BCD-1232', 3, 2017),
  ('BBB-1532', 4, 2018),
  ('BAB-1C22', 4, 2020),
  ('CCC-4567', 6, 2020),
  ('DDD-2D33', 7, 2021),
  ('ZZZ-9876', 8, 2016),
  ('ZYZ-9876', 8, 2017),
  ('MDC-0011', 9, 2019);