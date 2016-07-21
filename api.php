<?php
include("Carro.class.php");

if($_POST['_METHOD'] == ""){
	$request = $_SERVER["REQUEST_METHOD"];	
}else{
	$request = $_POST['_METHOD'];
}
if($request == "POST"){
	
	$carro = new Carro();
	$carros = $carro->getCarros();
	$arrayCarros = array();
	foreach($carros as $carroa){
		$ultimoid = $carroa['id'];
		$arrayCarros[] = array("id"=>$carroa['id'],"carro"=>$carroa['carro'],"marca"=>$carroa['marca'],"ano"=>$carroa['ano']);

	}
	$arrayCarros[] = array("id"=>$ultimoid+1,"carro"=>$_POST['carro'],"marca"=>$_POST['marca'],"ano"=>$_POST['ano']);
	
	$fp = fopen('json.json', 'w');
	fwrite($fp, json_encode($arrayCarros));
	fclose($fp);
	echo "OK";
	
}
if($request == "GET"){
	$carro = new Carro();
	$carros = $carro->getCarros();
	$marcas = $carro->getMarcas();

}
if($request == "DELETE"){
	$carro = new Carro();
	$carros = $carro->getCarros();
	$arrayCarros = array();
	foreach($carros as $carroa){
		if($carroa['id'] != $_POST['id']){
			$arrayCarros[] = array("id"=>$carroa['id'],"carro"=>$carroa['carro'],"marca"=>$carroa['marca'],"ano"=>$carroa['ano']);
		}
	}
	
	$fp = fopen('json.json', 'w');
	fwrite($fp, json_encode($arrayCarros));
	fclose($fp);
	echo "OK";
}
if($request == "PUT"){
	$carro = new Carro();
	$carros = $carro->getCarros();
	$arrayCarros = array();
	foreach($carros as $carroa){
		if($carroa['id'] != $_POST['id']){
			$arrayCarros[] = array("id"=>$carroa['id'],"carro"=>$carroa['carro'],"marca"=>$carroa['marca'],"ano"=>$carroa['ano']);	
		}
		
	}
	$arrayCarros[] = array("id"=>$_POST['id'],"carro"=>$_POST['carro'],"marca"=>$_POST['marca'],"ano"=>$_POST['ano']);
	function cmp($a, $b) {
		return $a['id'] > $b['id'];
	}
	 
	// Ordena
	usort($arrayCarros, 'cmp');
	$fp = fopen('json.json', 'w');
	fwrite($fp, json_encode($arrayCarros));
	fclose($fp);
	echo "OK";
}
?>