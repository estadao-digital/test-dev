# ************************************************************
# Sequel Pro SQL dump
# Versão 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Base de Dados: carros
# Tempo de Geração: 2020-07-06 06:00:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela carros
# ------------------------------------------------------------

DROP TABLE IF EXISTS `carros`;

CREATE TABLE `carros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(32) NOT NULL,
  `ano` decimal(10,0) NOT NULL,
  `marca_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `carros` WRITE;
/*!40000 ALTER TABLE `carros` DISABLE KEYS */;

INSERT INTO `carros` (`id`, `modelo`, `ano`, `marca_id`, `created`, `modified`)
VALUES
	(1,'Civic',2000,2,'2020-06-06 02:00:00','2020-07-06 02:46:28'),
	(2,'Fiesta',2010,4,'2020-07-06 02:48:05','2020-07-06 02:48:05'),
	(4,'Gol',1997,5,'2020-07-06 02:48:25','2020-07-06 02:48:25'),
	(7,'Corolla',2010,1,'2020-07-06 02:48:51','2020-07-06 02:48:51'),
	(8,'HB20',2019,6,'2020-07-06 02:49:53','2020-07-06 02:49:53'),
	(12,'Stilo',2000,4,'2020-07-06 02:55:12','2020-07-06 02:55:12');

/*!40000 ALTER TABLE `carros` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela marcas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `marcas`;

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;

INSERT INTO `marcas` (`id`, `name`, `created`, `modified`)
VALUES
	(1,'Toyota','2020-06-05 10:00:00','2020-07-06 01:00:19'),
	(2,'Honda','2020-06-06 00:10:10','2020-07-06 01:57:40'),
	(3,'Ford','2020-06-06 02:00:00','2020-07-06 02:42:42'),
	(4,'Fiat','2020-06-06 02:10:00','2020-07-06 02:43:02'),
	(5,'Volkswagen','2020-06-06 02:20:00','2020-07-06 02:43:48'),
	(6,'Hyundai','2020-06-06 02:30:00','2020-07-06 02:44:34'),
	(7,'Volvo','2020-06-06 02:33:00','2020-07-06 02:44:58');

/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
