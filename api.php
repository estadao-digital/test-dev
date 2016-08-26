<?php
include_once 'Carros.class.php';

//session_start();
$data_file="carros.json";

$carros_salvos = Carro::getFromArray(json_decode(file_get_contents($data_file),true));

$id=$_GET["id"];
$metodo=$_SERVER['REQUEST_METHOD'];
if($metodo=="GET"){
	$id=$_GET["id"];
	if($id){
		$carro=null;
		for ($i = 1; $i <= sizeof($carros_salvos); $i++) {
			if($carros_salvos[$i]->id==$id){
				$carro=$carros_salvos[$i];
				break;
			}
		}
		if($carro){
			echo json_encode($carro.toArray());
		}
	}else{
		$arr=array();
		foreach ($carros_salvos as $carro){
			$arr[]=$carro.toArray();
		}
		echo json_encode($arr);
	}
}
if($metodo=="POST"){
	$carro=Carro::getFromArray(json_decode(file_get_contents('php://input'),true));
	if($carro){
		$exists=false;
			for ($i = 1; $i <= sizeof($carros_salvos); $i++) {
				if($carros_salvos[$i]->id==$carro->id){
					$exists=true;
					break;
				}
			}
			if(!$exists){
				$carros_salvos[]=$carro;
			}else{
				
			}
	}
}
if($metodo=="PUT"){
	if($id){
		$carro=Carro::getFromArray(json_decode(file_get_contents('php://input'),true));
		if($carro){
			for ($i = 1; $i <= sizeof($carros_salvos); $i++) {
				if($carros_salvos[$i]->id==$carro->id){
					$carros_salvos[$i]=$carro;
					break;
				}
			}
		}
	}
}
if($metodo=="DELETE"){
	$id=$_GET["id"];
	if($id){
		for ($i = 1; $i <= sizeof($carros_salvos); $i++) {
			if($carros_salvos[$i]->id==$id){
				unset($carros_salvos[$i]);
				break;
			}
		}
	}
}
$arr=array();
foreach ($carros_salvos as $carro){
	$arr[]=$carro.toArray();
}
file_put_contents($data_file,json_encode($arr));
?>