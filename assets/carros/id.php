<?php
require_once '../Carro.class.php';

$idINFO = new Carros;
$idINFO -> recebe();
$idINFO -> proximoID($dataJSON -> carrosJSON);

switch ($idINFO -> getAction) {
	// Apaga
	case 'del':
		$idINFO -> apagar( 
			$dataJSON -> carrosJSON,
			$idINFO -> getID 
		);
		break;

	case 'cad':
		$idINFO -> cadastrar(
			$dataJSON -> carrosJSON,
			$idINFO -> getPrxID
		);
		break;

	case 'edit':
		$idINFO -> editar(
			$dataJSON -> carrosJSON,
			$idINFO -> getID
		);
		break;
}
?>