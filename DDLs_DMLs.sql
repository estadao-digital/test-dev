# Versão do MySQL: 5.7.27

CREATE SCHEMA `estadao` DEFAULT CHARACTER SET utf8 ;

# Se a tabela deve ser criada no plural ou no singular é discutível.
# No Laravel eu usaria as migrations que permite versionar as DDL's do banco.
CREATE TABLE `estadao`.`carros` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `ano` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`));

