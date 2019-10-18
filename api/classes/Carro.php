<?php

    class Carro {

        private $id;
        private $marca;
        private $modelo;
        private $ano;


        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        public function getMarca() {
            return $this->marca;
        }

        public function setMarca($marca) {
            $this->marca = trim($marca);
            return $this;
        }

        public function getModelo() {
            return $this->modelo;
        }

        public function setModelo($modelo) {
            $this->modelo = trim($modelo);
            return $this;
        }

        public function getAno() {
            return $this->ano;
        }

        public function setAno($ano) {
            $this->ano = $ano;
            return $this;
        }


        public function createCar() {

            $sql = MySql::conectar()->prepare("INSERT INTO `tb_carros` VALUES (?,?,?,?)");
            if($sql->execute(array($this->getId(),$this->getMarca(),$this->getModelo(),$this->getAno()))) {

                return true;

            }else {

                return false;

            }

        }

        public static function getCarros() {

            $sql = MySql::conectar()->prepare("SELECT C.id AS id, M.marca AS marca, C.modelo AS modelo, C.ano AS ano FROM `tb_carros` AS C INNER JOIN 
            `tb_marcas` AS M ON C.marca = M.id");
            $sql->execute();
            
            if($sql->rowCount() > 0) {

                return $sql->fetchAll();

            }else {

                return false;

            }

        }

        public static function getCarro($id) {

            $sql = MySql::conectar()->prepare("SELECT C.id AS id, M.marca AS marca, C.modelo AS modelo, C.ano AS ano FROM `tb_carros` AS C INNER JOIN 
            `tb_marcas` AS M ON C.marca = M.id WHERE C.id = ?");
            $sql->execute(array($id));
            
            if($sql->rowCount() > 0) {

                return $sql->fetch();

            }else {

                return false;

            }

        }

        public static function getMarcas() {

            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_marcas`");
            $sql->execute();
            
            if($sql->rowCount() > 0) {

                return $sql->fetchAll();

            }else {

                return false;

            }

        }

        public function updateCar() {

            $sql = MySql::conectar()->prepare("UPDATE `tb_carros` SET marca = ?,modelo = ?,
            ano = ? WHERE id = ?");
            if($sql->execute(array($this->getMarca(),$this->getModelo(),$this->getAno(),
            $this->getId()))) {

                return true;

            }else {

                return false;

            }

        }

        public function deleteCar() {

            $sql = MySql::conectar()->prepare("DELETE FROM `tb_carros` WHERE id = ?");
            if($sql->execute(array($this->getId()))) {

                return true;

            }else {

                return false;

            }

        }

        

        
    }
    

?>