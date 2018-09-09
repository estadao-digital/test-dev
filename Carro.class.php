<?php 
	require_once("TxtCarroController.php");

	if($_REQUEST['action'] == 'cadastrar')
    {
        //
    	if(isset($_POST["modelo"]) && isset($_POST["ano"]) && isset($_POST["marca"])){
    		$modelo = "modelo=".$_POST["modelo"];
    		$ano = "ano=".$_POST["ano"];
    		$marca = "marca=".$_POST["marca"];
    		$dados = "id=".uniqid()."&".$modelo."&".$ano."&".$marca."\n";
    		$retorno = cadastrar($dados);

    		if(!empty($retorno)){
    			die("1");
    		}else{
    			die("0");
    		}

    	}else{
    		die("2");
    	}
    	
    }

    else if($_REQUEST['action'] == 'listar'){
    	//header("Content-Type: application/json");
    	$carros = lerTxT();
        $response = array(
        'status' => true,
        'carros' => $carros
        );

        //echo json_encode($response);
    	
        die(json_encode($response));
    }else if($_REQUEST['action'] == "remover"){
        $resultado = removerCarro($_GET["item"]);
        die(json_encode($resultado));
    }else if($_REQUEST['action'] == "buscar"){

        die(json_encode(buscarCarroID($_REQUEST["item"])));

    }else if($_REQUEST['action'] == "alterar"){
        $method = $_SERVER['REQUEST_METHOD'];
        if ('PUT' === $method) {
            $dados = file_get_contents('php://input');

            $retorno = alterarCarro($dados);

            die($retorno);
        }
    }


    else{
    	return "falho";
    }




?>