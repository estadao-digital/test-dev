<?php

session_start();

//session_destroy();
//echo var_dump($_SESSION["carros"]);

if(isset($_SESSION['carros'])){


	$retornoLista = "
	<div class='title'>
	    Lista de Carros
	</div>
	<div class='content'>
	    <div class='carros'>
	    <input type='button' class='btn btn-success' value='Incluir Novo Carro' onclick='incluirCarro();'><br><br>
		<table class='table table-striped table-hover table-bordered'>
			<tr>
		        <th class='id'>ID</th>
		        <th>MARCA</th>
		        <th>MODELO</th>
		        <th class='ano'>ANO</th>
		        <th class='act'>AÇÕES</th>
		    </tr>
	";

	foreach ($_SESSION['carros'] as $carro) {
		$retornoLista .= "
		<tr>
			<td class='id'>".$carro["id"]."</td>
			<td>".$carro["marca"]."</td>
			<td>".$carro["modelo"]."</td>
			<td class='ano'>".$carro["ano"]."</td>
			<td class='act'>
				<img src='img/alterar_ico.png' class='img-alt-del' onclick='alteraCarro(".'"'.$carro["id"].'"'.");' title='Alterar'>
	            <img src='img/lixeira_vazia.png' class='img-alt-del' onclick='deletarCarro(".'"'.$carro["id"].'"'.");' title='Excluir'>
			</td>
		</tr>
		";
		
	}

	$retornoLista .= "
		</table>
	 	</div>
	</div>";

}else{

	$retornoLista = "
		<div class='title'>
		    Não existem carros cadastrados!<br>
			Favor incluir!<br><br><br>
		<input type='button' class='btn btn-success' value='Incluir Novo Carro' onclick='incluirCarro();'>
		</div>
	";

}


echo $retornoLista;

?>