-- MYSQL
CREATE TABLE `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `car_name` varchar(255) NOT NULL COMMENT 'modelo',
  `car_price` double NOT NULL COMMENT 'preço',
  `car_year` int(11) NOT NULL COMMENT 'ano',
  `car_brand` int(11) DEFAULT NULL COMMENT 'marca',
  `car_status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1 COMMENT='datatable demo table';
