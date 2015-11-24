<?
	include_once("api.php");
	
	$api  = new api();
	
	$carro = new Carro();
	$carro->setAno(2015);
	$carro->setModelo("Fusca");
	$api->addCarro($carro);
	
	echo $api->getCarro(0);

	$carro = $api->getCarro(0);
	//$api->deleteCarro(0);

	$db  = new CarroDb();
	print_r($db->get(0));
	
	$db->deleteAll();
?>