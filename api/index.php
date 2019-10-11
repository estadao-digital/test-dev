<?php
header('Access-Control-Allow-Origin: *');

require_once 'limonade.php';
require_once 'lemon_mysql.php';

dispatch('/', function() {
	echo `Uso da REST/API:		
	    <br/> /carros - [GET] deve retornar todos os carros cadastrados.
	    <br/> /carros - [POST] deve cadastrar um novo carro.
	    <br/> /carros/{id}[GET] deve retornar o carro com ID especificado.
	    <br/> /carros/{id}[PUT] deve atualizar os dados do carro com ID especificado.
	    <br/> /carros/{id}[DELETE] deve apagar o carro com ID especificado.
		`;
});

dispatch_get('/carros', function() {
	$ok = db("SELECT * FROM carros");
	if($ok)
		return $ok;
	else
		erro("Nenhum carro encontrado");
});

dispatch_post('/carros', function() {
	if(isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['ano'])) {
		$ok = db("INSERT INTO `carros` (`id`, `marca`, `modelo`, `ano`) VALUES (NULL, '".$_POST['marca']."', '".$_POST['modelo']."', '".$_POST['ano']."');");
		if($ok)
			sucesso("Carro inserido");
		else
			sucesso("Erro ao inserir carro");
	} else {	
		erro("Favor preencher marca, modelo e ano");
	}
});

dispatch_get('/carros/:id', function() {
	$id = params('id');
	$achou = db("SELECT * FROM `carros` WHERE id = $id");
	
	if($achou) 
		return $achou;
	else
		erro("Carro $id não encontrado");
});


dispatch_put('/carros/:id', function() {
	$id = params('id');
	if(isset($_GET['marca']) || isset($_GET['modelo']) || isset($_GET['ano'])) {
		$ok1=$ok2=$ok3=true;
		if(isset($_GET['marca']))
			$ok1 = db("UPDATE `carros` SET `marca` = '".$_GET['marca']."' WHERE `carros`.`id` = $id;");

		if(isset($_GET['modelo']))
			$ok2 = db("UPDATE `carros` SET `modelo` = '".$_GET['modelo']."' WHERE `carros`.`id` = $id;");

		if(isset($_GET['ano']))
			$ok3 = db("UPDATE `carros` SET `ano` = '".$_GET['ano']."' WHERE `carros`.`id` = $id;");
		
		if($ok1 && $ok2 && $ok3)
			sucesso("Carro $id atualizado com sucesso");
		else
			erro("Erro ao atualizar o carro $id");
	} else {	
		erro("Favor preencher marca ou modelo ou ano para atualizar o carro $id");
	}
});

dispatch_delete('/carros/:id', function() {
	$id = params('id');
	$del = db("DELETE FROM `carros` WHERE id = $id");
	if($del)
		sucesso("Deletado o carro $id");
	else
		erro("Erro ao deletar o carro $id");
});

function sucesso($msg) {
	echo '{ "error": false, "msg": "'.$msg.'"}';
}

function erro($msg) {
	echo '{ "error": true, "msg": "'.$msg.'"}';
}

run();


?>