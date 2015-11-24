<?
session_start();
include_once("Carro.db.php");
include_once("Marca.class.php");

function __autoload($name) {
	include $name . '.class.php';
}

	class api{
		var $carro;
		var $marca;
		var $db;
		public function api(){
			$this->db=new CarroDb();
			$this->marca = new Marca();
		}
		
		public function getCarro($id){
			return json_encode($this->db->get($id));
		}
		
		public function getCarros(){
			echo json_encode($this->db->getAll());
		}
		
		public function addCarro($carro){			
			$this->db->add($carro);
			return json_encode($carro);
		}
		
		public function updateCarro($carro){
			$this->db->update($carro);
			return json_encode($carro);
		}
		
		public function deleteCarro($id){
			$this->db->delete($id);
			return json_encode($carro);
		}
		
		public function getMarcas(){
			return json_encode($this->marca->getAll());
			
		}
		
		public function parseCarro($obj){
			$carro = new Carro();
			if(isset($obj->Modelo))
				$carro->setModelo($obj->Modelo);
			
			if(isset($obj->Ano))
				$carro->setAno($obj->Ano);
			
			if(isset($obj->Id))
				$carro->setId($obj->Id);
			
			if(isset($obj->IdMarca))
				$carro->setIdMarca($obj->IdMarca);
				
			return $carro;
		}
		
		public function getRequest(){
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			return $request;
		}
		
		public function error(){
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		}
		

	}
	
	
if (isset($_GET["action"]))
{
	$api = new api();
	$request = $api->getRequest();
	//print_r($_GET);
  switch ($_GET["action"])
    {
		
      case "get":
        	echo $api->getCarro($_GET["id"]);
        break;
      case "getAll":
	  		try{
        		echo $api->getCarros();
			}catch(Exception $e){
				$api->error();
			}
        break;
		case "create":	
			try{		
				$carro = $api->parseCarro($request);
				echo $api->addCarro($carro);
			}catch(Exception $e){
				$api->error();
			}
		break;
		case "update":	
			
			$carro = $api->parseCarro($request);	
			echo $api->updateCarro($carro);
		break;		
		case "delete":
		
			echo $api->deleteCarro($_GET["id"]);
		break;
		
		case "getMarcas":
			echo $api->getMarcas();
		break;
    }
}
?>