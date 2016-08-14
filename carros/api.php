<?php

include_once 'Carro.class.php';

$method_type = $_SERVER["REQUEST_METHOD"];

$path = dirname(getcwd()) . '/dataserver/carros.json';

# Todas as chamadas neste api são realizadas para os metodos da classe Carro

if($method_type === 'GET')
{
	if($_GET['id'] === '')
	{
		if((new Carro($path))->getValues() == ''){
			echo '{"RETORNO":"SEM-CADASTROS"}';
		}
		else 
		{
			echo (new Carro($path))->getValues();
		}
	}
	elseif($_GET['id'] !== '')
	{
		echo (new Carro($path))->getValueID($_GET['id']);
	}
}
elseif($method_type === 'POST')
{
	if($_POST['acao'] === 'Cadastrar')
	{
		echo (new Carro($path))->setValue($_POST);
	}
}
elseif($method_type === 'PUT')
{
	$retorno_put = explode('&', file_get_contents('php://input'));
	foreach ($retorno_put as $values) {
		$value = explode('=', $values);
		$put[$value[0]] = $value[1];
	}
	if($put['acao'] === 'Editar')
	{
		echo (new Carro($path))->atualizaValue($put);
	}
}
elseif($method_type === 'DELETE')
{
	$retorno_delete = explode('&', file_get_contents('php://input'));
	foreach ($retorno_delete as $values) {
		$value = explode('=', $values);
		$delete[$value[0]] = $value[1];
	}
	if($delete['acao'] === 'Deletar')
	{
		echo (new Carro($path))->deletarValue($delete);
	}
}
