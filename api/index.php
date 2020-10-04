<?php

	$route 	= $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];

	$route = substr($route, 1);
	$route = explode("?", $route);
	$route = explode("/", $route[0]);
	$route = array_diff($route, array('test-dev', 'api'));
	$route = array_values($route);

	$arr_json = null;

	if (count($route) <= 2) {
		
		switch ($route[0]) {
			case 'carro':

				include('Carro.class.php');
				$carro = new Carro($_REQUEST['marca'],$_REQUEST['modelo'],$_REQUEST['ano']);
				$arr_json = $carro->verifyMethod($method,$route);
				break;
			
			default:
				$arr_json = array('status' => 404);
				break;
		}

	}else{
		$arr_json = array('status' => 404);
	}

	echo json_encode($arr_json);

?>