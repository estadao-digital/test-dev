<?
 class Carro{
	public $Id;
	public $IdMarca;
	public $Modelo;
	public $Ano;

	public function Carro(){
		$_SESSION["carro_db"] =(!isset($_SESSION["carro_db"]))? array():$_SESSION["carro_db"];
	}

	public function setId($Id){
		$this->Id = $Id;
	}

	public function setIdMarca($IdMarca){
		$this->IdMarca = $IdMarca;
	}

	public function setModelo($Modelo){
		$this->Modelo = $Modelo;
	}

	public function setAno($Ano){
		$this->Ano = $Ano;
	}

	public function getId(){
		return $this->Id;
	}

	public function getIdMarca(){
		return $this->IdMarca;
	}

	public function getModelo(){
		return $this->Modelo;
	}

	public function getAno(){
		return $this->Ano;
	}
	

		
		

}
?>