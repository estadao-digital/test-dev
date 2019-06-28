<?php
/**
* Classe do carro
*/

class Carros {
	// VAR Dados Carros
	var $arquivoJSON;
	var $dadosJSON;
	var $carrosJSON;

	// VAR Dados Marcas
	var $arquivoMJSON;
	var $dadosMJSON;
	var $marcasJSON;

	// VAR Carros
	var $ID;
	var $Marca;
	var $Modelo;
	var $Ano;

	// VAR Gets
	var $getID;
	var $getAction;
	var $getMarca;
	var $getModelo;
	var $getAno;
	var $getPrxID;

	// Info
	public function recebe() {
		$this -> getID = isset($_GET['id']) ? $_GET['id']: '';
		$this -> getAction = isset($_POST['action']) ? $_POST['action']: '';
	}

	// Próximo ID
	public function proximoID($dbJSON) {
		$proxID = 0;
		foreach ($dbJSON as $carro) {
			$proxID = $carro->ID;
		}
		$proxID++;

		$this -> getPrxID = $proxID;
	}

	// Cadastrar
	public function cadastrar($dbMJSON, $proximoID) {
		$this -> getMarca = isset($_POST['marca']) ? $_POST['marca']: '';
		$this -> getModelo = isset($_POST['modelo']) ? $_POST['modelo']: '';
		$this -> getAno = isset($_POST['ano']) ? $_POST['ano']: '';
		$this -> getPrxID = $proximoID;

		$novoCarro = array (
			"ID"=>$this -> getPrxID,
			"Marca"=>$this -> getMarca,
			"Modelo"=>$this -> getModelo,
			"Ano"=>$this -> getAno
		);
		//var_dump($novoCarro);
		array_push($dbMJSON, $novoCarro);
		file_put_contents('carros.json', json_encode($dbMJSON));
		echo 'cadastrado';
	}

	// Editar
	public function editar() {

	}

	// Apagar
	public function apagar($dbJSON, $apagaID) {
		$i=0;
		foreach ($dbJSON as $carro) {
			if($apagaID == $carro->ID){
				unset($dbJSON[$i]);
				file_put_contents('carros.json', json_encode($dbJSON));
				echo 'apagado';
			}
			$i++;
		}
	}
}

$dataJSON = new Carros;
$dataJSON -> arquivoJSON = 'carros.json';
$dataJSON -> dadosJSON = file_get_contents($dataJSON -> arquivoJSON);
$dataJSON -> carrosJSON = json_decode($dataJSON -> dadosJSON);
//var_dump($dataJSON);

$dataMJSON = new Carros;
$dataMJSON -> arquivoMJSON = 'marcas.json';
$dataMJSON -> dadosMJSON = file_get_contents($dataMJSON -> arquivoMJSON);
$dataMJSON -> marcasJSON = json_decode($dataMJSON -> dadosMJSON);
//var_dump($dataMJSON);
?>