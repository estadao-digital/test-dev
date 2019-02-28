CREATE DATABASE dealer_car

USE dealer_car

CREATE TABLE brands(
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL
)

INSERT INTO brands(name) VALUES('Fiat');
INSERT INTO brands(name) VALUES('Volkswagen');
INSERT INTO brands(name) VALUES('BMW');
INSERT INTO brands(name) VALUES('Chevrolet');
INSERT INTO brands(name) VALUES('Peugeot');
INSERT INTO brands(name) VALUES('Renault');
INSERT INTO brands(name) VALUES('Ford');
INSERT INTO brands(name) VALUES('Hyundai');
INSERT INTO brands(name) VALUES('Nissan');

CREATE TABLE cars(
	id INT PRIMARY KEY AUTO_INCREMENT,
	model VARCHAR(255) NOT NULL,
	year INT NOT NULL,
	brandId INT NOT NULL
)

ALTER TABLE cars ADD CONSTRAINT fk_brand_car FOREIGN KEY (brandId) REFERENCES brands(id);