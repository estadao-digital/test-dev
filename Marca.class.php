<?php 
	require_once("TxtMarcaController.php");

	if($_REQUEST['action'] == 'cadastrar')
    {

    	if(isset($_POST["marca"])){
    	    $marca = $_POST["marca"];

    	    $retorno = cadastrar($marca."\n");
    		if(!empty($retorno)){
    		    die("1");
    		}else{
    		    die("0");
    		}

    	}else{
    		die("0");
    	}
    	
    }else if($_REQUEST['action'] == 'listar'){
    	//header("Content-Type: application/json");
    	$marcas = lerTxT();
        $response = array(
        'status' => true,
        'marcas' => $marcas
        );

        //echo json_encode($response);
    	
        die(json_encode($response));
    }else if($_REQUEST['action'] == "remover"){

        $resultado = removerMarca($_GET["item"]);
        if(!empty($resultado)){
            die("1");
        }
            die("0");
    }else if($_REQUEST['action'] == "teste"){
        lerTxTTeste();
    }


    else{
    	return "falho";
    }




?>