<?php
//session_start();
require_once("Carro.class.php");

// Mensagens de Erro 
$msg[0] = "Conexão com o banco falhou!"; 
$msg[1] = "Não foi possível selecionar o banco de dados!"; 

// Fazendo a conexão com o servidor MySQL 
$conexao = mysql_pconnect("localhost","root","") or die($msg[0]); 
mysql_select_db("teste",$conexao) or die($msg[1]);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

$carro = new Carro();

//echo $method.' '.$_GET['id']; die;

switch ($method) {
  case 'PUT':
    //var_dump($_REQUEST);
	$carro->atualizar($_REQUEST['id'],$_REQUEST['marca'],$_REQUEST['modelo'],$_REQUEST['ano']);
	$carro->listar();
    break;
  case 'POST':
    echo "POST";
    break;
  case 'GET':
    // do_something_with_get($request);
	if($_GET["id"]==''){
		$carro->listar();
	}else{
		$carro->form($_GET['id']); 
	}	
	break;
  case 'DELETE':
    // do_something_with_delete($request);  
    break;
  default:
    // handle_error($request);  
    break;
}

?>