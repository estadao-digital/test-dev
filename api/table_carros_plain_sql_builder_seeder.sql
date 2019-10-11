CREATE TABLE IF NOT EXISTS `carros` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `ano` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
INSERT INTO `carros` (`id`, `marca`, `modelo`, `ano`) VALUES
  ('1', 'FIAT', 'Uno', 1997),
  ('2', 'Cherry', 'QQ', 2018);
