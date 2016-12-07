<?php

session_start();

$qtdLista = 0;
$id = 1;
$marca = "ford";
$model = "ká";
$ano = "2015";

$_SESSION['carros'] = (
		    array($qtdLista =>
		        array("id" => $id,
		              "marca" => $marca,
		              "modelo" => $model,
		              "ano" => $ano
	            )
		    )
);

foreach ($_SESSION['carros'] as $carro) {
	echo "carro:" . $carro["id"];
}

?>