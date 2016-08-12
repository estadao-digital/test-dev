<?php
	require_once("..\Carro.class.php");	
	require_once("Rest.inc.php");

	session_start();
	error_reporting(E_ERROR);
	//unset($_SESSION);

	
	//print "<pre>".print_r($_SESSION,true)."</pre>";	
	
	class API extends REST {
	
		public $data = "";
		
		private $servicosdb = NULL;
	
		public function __construct(){
			parent::__construct();				
			$this->dbConnect();					
		}

		private function dbConnect(){
			if (!isset($_SESSION['carroEmGaragem'])){
				$_SESSION['carroEmGaragem'][0] = new Carro("1", "Ford", 	"EcoSport",	"2005");
				$_SESSION['carroEmGaragem'][1] = new Carro("2", "Ford", 	"Novo KA" ,	"2010");
				$_SESSION['carroEmGaragem'][2] = new Carro("3", "Chevrolet","Corsa" ,	"2015");
				$_SESSION['carroEmGaragem'][3] = new Carro("4", "Fiat", 	"Strada" ,	"2013");
				$_SESSION['carroEmGaragem'][4] = new Carro("5", "Chevrolet","Malibu" ,	"1970");
			}			
		}
		
		
		
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);
		}
		
		
		private function carros(){	
			switch($this->get_request_method()){
				case "GET":
					$id = (int)$this->_request['id'];
					if($id > 0){		
						$carro = $this->obterCarro($id);	
						$result = $this->objetoToArray($carro);
						$this->response($this->json($result), 200);
					}else{
						$carros = $this->listCarros();
						foreach ($carros as $carro) {
							$result[] = $this->objetoToArray($carro);
						}
						$this->response($this->json($result), 200);
					}	
					break;
				case "POST":
					$marca  = $this->_request['marca'];
					$modelo = $this->_request['modelo'];
					$ano    = $this->_request['ano'];
					$novo   = new Carro("0",$marca,$modelo,$ano);
					$result = $this->inserirCarro($novo);
					$retorno = array("inserido"=>$result);
					$this->response($this->json($retorno), 200);
					break;
				case "PUT":
					$id  	= $this->_request['id'];
					$marca  = $this->_request['marca'];
					$modelo = $this->_request['modelo'];
					$ano    = $this->_request['ano'];
					$editado= new Carro($id,$marca,$modelo,$ano);
					$result = $this->atualizarCarro($editado);
					$result = $this->objetoToArray($editado);
					$this->response($this->json($result), 200);
					break;
				case "DELETE":
					$id = (int)$this->_request['id'];
					$result = $this->removerCarro($id);
					$retorno = ($result)?array("removido"=>"true"):array("removido"=>"false");
					$this->response($this->json($retorno), 200);
					break;
				
				default:	
					$this->response('',406);
			}
			$this->response('',204);	
		}
		
		 
		
		public function listCarros(){
			$lista = array();
			if (isset($_SESSION['carroEmGaragem'])){
				foreach ($_SESSION['carroEmGaragem'] as $carro) {
					if ($carro->getRemovido()==0) $lista[] = $carro;
				}
			}
			return $lista;
		}
		
		public function removerCarro($idCarro){
			$removido = false;
			foreach ($_SESSION['carroEmGaragem'] as $carro) {
				if ($carro->getId()==$idCarro) {
					$carro->setRemovido(1);
					$removido = true;
				}
			}
			return $removido;
		}
		
		public function obterCarro($idCarro) {
			$retornoCarro = new Carro();
			foreach ($_SESSION[carroEmGaragem] as $carro) {
				if ($carro->getId()==$idCarro) $retornoCarro = $carro;
			}
			return $retornoCarro;
		}
		
		public function inserirCarro($carronovo){
			$novoId = 0;
			foreach ($_SESSION[carroEmGaragem] as $carro) {
				if ($carro->getId()>$novoId) $novoId = $carro->getId();
			}
			$novoId++;
			$carronovo->setId($novoId);
			$_SESSION[carroEmGaragem][] = $carronovo;
			return $novoId;
		}
		
		public function atualizarCarro($carroEditado){
			foreach ($_SESSION[carroEmGaragem] as $carro) {
				if ($carro->getId()==$carroEditado->getId()) {
					$carro->setMarca($carroEditado->getMarca());
					$carro->setModelo($carroEditado->getModelo());
					$carro->setAno($carroEditado->getAno());
				}
			}
			return $this->countCarros();
		}
		
		public function objetoToArray($objetoCarro){
			$array = array();
			$array['id']     = $objetoCarro->getId();
			$array['marca']  = $objetoCarro->getMarca();
			$array['modelo'] = $objetoCarro->getModelo();
			$array['ano'] 	 = $objetoCarro->getAno();
		
			return $array;
		}

		public function countCarros() {
			$contagem = 0;
			foreach ($_SESSION[carroEmGaragem] as $carro) {
				if ($carro->getRemovido()==0) $contagem++;
			}
			return $contagem;
		}
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	$api = new API;
	$api->processApi();
?>