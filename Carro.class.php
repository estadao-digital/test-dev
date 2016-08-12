<?php
//session_start();

class Carro {
	private $id;
	private $marca;
	private $modelo;
	private $ano;
	private $removido;
	
	function __construct($strId = 0, $strMarca = "",$strModelo = "",$strAno = "") {
		$this->id 		= $strId;
		$this->marca 	= $strMarca;
		$this->modelo 	= $strModelo;
		$this->ano		= $strAno;
		$this->removido = 0;
	}
	
	function setId($strId) 			{$this->id = $strId;}
	function setMarca($strMarca) 	{$this->marca = $strMarca;}
	function setModelo($strModelo) 	{$this->modelo = $strModelo;}
	function setAno($strAno) 		{$this->ano = $strAno;}
	function setRemovido($strDel) 		{$this->removido = $strDel;}
	
	function getId()     			{return $this->id;}
	function getMarca()  			{return $this->marca;}
	function getModelo() 			{return $this->modelo;}
	function getAno() 	 			{return $this->ano;}
	function getRemovido() 			{return $this->removido;}
}

/* Serviços de banco de dados */
/*
class Garagem {
	function __construct() {
		if (!isset($_SESSION[carroEmGaragem])){
			$carro 		= Array();
			$carro[0] 	= new Carro("1", "Ford", 		"EcoSport",	"2005");
			$carro[1] 	= new Carro("2", "Ford", 		"Novo KA" ,	"2010");
			$carro[2] 	= new Carro("3", "Chevrolet", 	"Corsa" ,	"2015");
			$carro[3] 	= new Carro("4", "Fiat", 		"Strada" ,	"2013");
			
			$_SESSION[carroEmGaragem][0] = $carro[0];
			$_SESSION[carroEmGaragem][1] = $carro[1];
			$_SESSION[carroEmGaragem][2] = $carro[2];
			$_SESSION[carroEmGaragem][3] = $carro[3];
		}
	}
	public function obterCarro($idCarro) {
		$retornoCarro = new Carro();
		foreach ($_SESSION[carroEmGaragem] as $carro) {
			if ($carro->getId()==$idCarro) $retornoCarro = $carro;
		}
		return $retornoCarro;
	}
	public function countCarros() {
		$contagem = 0;
		foreach ($_SESSION[carroEmGaragem] as $carro) {
			if ($carro->getRemovido()==0) $contagem++;
		}
		return $contagem;
	}
	public function listCarros(){
		$lista = array();
		foreach ($_SESSION[carroEmGaragem] as $carro) {
			if ($carro->getRemovido()==0) $lista[] = $carro;
		}
		return $lista;
	}
	public function inserirCarro($carro){
		$_SESSION[carroEmGaragem][] = $carro;
		return $this->countCarros();
	}
	public function removerCarro($idCarro){
		foreach ($_SESSION[carroEmGaragem] as $carro) {
			if ($carro->getId()==$idCarro) {
				$carro->setRemovido(1);
			}
		}
		return $this->countCarros();
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
}
*/
/*
 * 
TESTES 

$garagem = new Garagem();
$outrocarro = new Carro("4","Nissan","Sentra","1995");

$carro_2 = $garagem->obterCarro(2);

$carro_2->setMarca("Ford edt");
$carro_2->setModelo("Novo KA edt");
$carro_2->setAno("2016");

$editar = $garagem->atualizarCarro($carro_2);

//echo "qt Carros: ".$garagem->countCarros();
echo "<br>carro 2 reformado!";
//$agoraqt = $garagem->removerCarro(4);

//echo "<br>carro_2= ID:".$carro_2->getId()." Marca:".$carro_2->getMarca()." Modelo:".$carro_2->getModelo()." Ano:".$carro_2->getAno();
//echo "<br>agora temos ".$agoraqt." carro(s).";

$carro_2_reformado = $garagem->obterCarro(2);
print "<pre>".print_r($carro_2_reformado ,true)."</pre>";

$carros = $garagem->listCarros();

print "<pre>".print_r($carros ,true)."</pre>";


//echo "marca:".$outrocarro[1]->getMarca()." modelo:".$outrocarro[1]->getModelo();

print "<pre>".print_r($_SESSION,true)."</pre>";
//unset($_SESSION[pessoa]);
**/
?>


