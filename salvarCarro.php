<?php

	session_start();

	$id = $_POST["id"];
	$marca = $_POST["marca"];
	$modelo = $_POST["model"];
	$ano = $_POST["ano"];

	if(isset($_SESSION['carros'])){
		$qtdLista = count($_SESSION['carros']);	
		$_SESSION['carros'] += (
	        array($qtdLista + 1 =>
	            array("id" => $id,
	                  "marca" => $marca,
	                  "modelo" => $modelo,
	                  "ano" => $ano)
	        )
	    );
	}else{
		$_SESSION['carros'] = array();
		$qtdLista = 1;
		$_SESSION['carros'] = (
	        array($qtdLista =>
	            array("id" => $id,
	                  "marca" => $marca,
	                  "modelo" => $modelo,
	                  "ano" => $ano)
	        )
	    );
	}
	

	

?>