<?
	include_once("Carro.class.php");
	class CarroDb{
		var $db;
		public function CarroDb(){
		
			$_SESSION["carro_db"] = isset($_SESSION["carro_db"])?$_SESSION["carro_db"]:array();
			
			$this->db=$_SESSION["carro_db"];
		}

		private function setDb($value){
			$_SESSION["carro_db"] = $value;
			$this->db=$_SESSION["carro_db"];
		}

		private function getDb(){
			return $this->db;
		}

		public function get($id){
			$carro = isset($_SESSION["carro_db"][$id])?$_SESSION["carro_db"][$id]:null;
			return $carro;
		}
		
		public function getAll(){
			return $this->db;
		}
		
		public function add(Carro $carro){			
			array_push($this->db,$carro);
			//$key = count($this->db);
			$key = array_search($carro, $this->db);
			$carro->setId($key);
			
			$this->setDb($this->db);
		}
		
		public function update(Carro $carro){
			$obj = $this->get($carro->getId());
			$obj->setModelo($carro->getModelo());
			$obj->setIdMarca($carro->getIdMarca());
			$obj->setAno($carro->getAno());
			$this->setDb($this->db);
		}
		
		public function delete($id){
			$obj = $this->get($id);
			array_splice($this->db,$id,1);
			$this->setDb($this->db);
		}

		public function deleteAll(){
			$this->setDb(null);
		}
	}
?>