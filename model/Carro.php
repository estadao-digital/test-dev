<?php

    class Carro {
        private $id;
        private $marca;
        private $modelo;
        private $ano;

        public function __construct(){}

        private function generateId(){
            // Esta função cria um identificador de 32 caracteres(a 128 bit hex number).
            $this->id = md5(uniqid(rand(), true));
        }

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }
    
        public function getMarca(){
            return $this->marca;
        }
    
        public function setMarca($marca){
            $this->marca = $marca;
        }
    
        public function getModelo(){
            return $this->modelo;
        }
    
        public function setModelo($modelo){
            $this->modelo = $modelo;
        }
    
        public function getAno(){
            return $this->ano;
        }
    
        public function setAno($ano){
            $this->ano = $ano;
        }

        public function create(){

            include('Database.php');

            try{
                $this->generateId();

                $stmt = $con->prepare("INSERT INTO carro(id, marca, modelo, ano) VALUES (?, ?, ?, ?) ");
                $stmt->bindParam(1,$this->id);
                $stmt->bindParam(2,$this->marca);
                $stmt->bindParam(3,$this->modelo);
                $stmt->bindParam(4,$this->ano);
                $stmt->execute();

                return [
                    'success' => true,
                    'message' => 'Carro criado com sucesso.',   
                ];

            }catch(PDOException $e){

                return [
                    'success' => false,  
                    'message' => $e->getMessage(),  
                ];
            }
        }

        public function read(){

            include('Database.php');

            try{
                $stmt = $con->prepare("SELECT * FROM carro WHERE id = ?");
                $stmt->bindParam(1,$this->id);
                $stmt->execute();

                $dadosCarro = $stmt->fetch(PDO::FETCH_OBJ);

                $this->marca = $dadosCarro->marca;
                $this->modelo = $dadosCarro->modelo;
                $this->ano = $dadosCarro->ano;

                return [
                    'success' => true,
                    'message' => 'Dados do carro carregados com sucesso.',   
                ];

            }catch(PDOException $e){

                return [
                    'success' => false,  
                    'message' => $e->getMessage(),  
                ];
            }
            
        }

        public function update(){

            include('Database.php');

            try{
                $stmt = $con->prepare("UPDATE carro SET marca = ?, modelo = ?, ano = ? WHERE id = ?");
                $stmt->bindParam(1,$this->marca);
                $stmt->bindParam(2,$this->modelo);
                $stmt->bindParam(3,$this->ano);
                $stmt->bindParam(4,$this->id);
                $stmt->execute();

                return [
                    'success' => true,
                    'message' => 'Dados do carro atualizados com sucesso.',   
                ];

            }catch(PDOException $e){

                return [
                    'success' => false,  
                    'message' => $e->getMessage(),  
                ];
            }
        }

        public function delete(){

            include('Database.php');

            try{
                $stmt = $con->prepare("DELETE FROM carro WHERE id = ?");
                $stmt->bindParam(1,$this->id);
                $stmt->execute();

                return [
                    'success' => true,
                    'message' => 'Carro excluído com sucesso com sucesso.',   
                ];

            }catch(PDOException $e){

                return [
                    'success' => false,  
                    'message' => $e->getMessage(),  
                ];
            }
        }

        public static function list(){

            include('Database.php');

            try{
                $stmt = $con->prepare("SELECT * FROM carro");
                $stmt->execute();

                $listaCarros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return [
                    'success' => true,
                    'message' => 'Lista de carros carregada com sucesso.', 
                    'data' => $listaCarros,  
                ];

            }catch(PDOException $e){

                return [
                    'success' => false,  
                    'message' => $e->getMessage(),  
                ];
            }

        }

        public function jsonMount(){

            return [
                'id' => $this->id,
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'ano' => $this->ano,
            ];

        }

    }

?>