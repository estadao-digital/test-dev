<?
 class Marca{
	private $Id;
	private $Nome;

	public function Marca(){}

	public function setId($Id){
		$this->Id = $Id;
	}

	public function setNome($Nome){
		$this->Nome = $Nome;
	}

	public function getId(){
		return $this->Id;
	}

	public function getNome(){
		return $this->Nome;
	}
	
	public function getAll(){
		$marcas = array();
		array_push($marcas,array("Id"=>0,"Nome"=>"Fiat"));
		array_push($marcas,array("Id"=>1,"Nome"=>"Ford"));
		array_push($marcas,array("Id"=>2,"Nome"=>"Chevrolet"));
		array_push($marcas,array("Id"=>3,"Nome"=>"Volkswagen"));
		return $marcas;
	}

}
?>