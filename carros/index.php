<?php
$func=  $_POST["func"];

if($func=='GET'){

	$string = file_get_contents("carros.json");
	if(isset($_POST["id"])){
		$get =$_POST["id"];
		$tempArray = json_decode($string,true);
		foreach ($tempArray as $key => $value){
			if($tempArray[$key]['id'] == $get){
				echo json_encode($tempArray[$key]);
			}
		}
	}else{
		echo $string;	                      
	}
}else if($func=='POST'){
		// Tamanho máximo do logo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024 * 5; // 2Mb
		// Array com as extensões permitidas
		$_UP['extensoes'] = array('jpg','png','jpeg','JPG','PNG','JPEG');
		// Renomeia o logo? (Se true, o logo será salvo como .jpg e um nome único)
		$_UP['renomeia'] = true;
		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O logo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O logo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do logo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do logo';
$id = file_get_contents("id.json");
$id = $id+1;
file_put_contents('id.json', $id);
		 $img="default";
		//FILE PJ
		$_UP['pasta'] = '../carros/upload/';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['foto']['error'] != 0) {
		  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['foto']['error']]);
		  exit; // Para a execução do script
		}
		// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
		// Faz a verificação da extensão do logo
		
		// Faz a verificação do tamanho do logo
		if ($_UP['tamanho'] < $_FILES['foto']['size']) {
		  // echo "O logo enviado é muito grande, envie logos de até 2Mb.";
		  exit;
		}
		// O logo passou em todas as verificações, hora de tentar movê-lo para a pasta
		// Primeiro verifica se deve trocar o nome do logo
		if ($_UP['renomeia'] == true) {
		  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
		  $nome_final = $id.".jpg";

		} else {
		  // Mantém o nome original do logo
		  $nome_final = $_FILES['foto']['name'];
		}
		  
		// Depois verifica se é possível mover o logo para a pasta escolhida
		if (move_uploaded_file($_FILES['foto']['tmp_name'], $_UP['pasta'] . $nome_final)) {
			 $img=$id;
		  // Upload efetuado com sucesso, exibe uma mensagem e um link para o logo
		  // echo "Upload efetuado com sucesso!";
		  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o logo</a>';
		} else {
		  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
		  // echo "Não foi possível enviar o logo, tente novamente";
		}

	$data =  ['id' => $id,'img' => $img,'marca' => $_POST["marca"],'carro' => $_POST["carro"],'modelo' => $_POST["modelo"],'dataano' => $_POST["dataano"],'datamodelo' => $_POST["datamodelo"]];
	$inp = file_get_contents('carros.json');
	$tempArray = json_decode($inp);
	if(isset($tempArray)){
		array_push($tempArray, $data);
	}else {
		$tempArray = [$data];
	}
	$jsonData = json_encode($tempArray);
	file_put_contents('carros.json', $jsonData);
}else if($func=='PUT'){
	$string = file_get_contents("carros.json");
	if(preg_match('/{+[0-9]+}/', $url, $get)){
		$get =substr($get[0],1,strlen($get[0])-2);
		$tempArray = json_decode($string,true);
		foreach ($tempArray as $key => $value){
			if($tempArray[$key]['id'] == $get){
				$tempArray[$key]=['id' => '1111', 'name' => 'ol444ha'];
			}
		}
		$newJson = json_encode($tempArray);
		file_put_contents('carros.json', $newJson);
	}else{
		echo `Sem parametro`;	
	}
}
else if($func=="DEL"){
	$string = file_get_contents("carros.json");
	if(preg_match('/{+[0-9]+}/', $url, $get)){
		$get =substr($get[0],1,strlen($get[0])-2);
		$tempArray = json_decode($string,true);
		foreach ($tempArray as $key => $value){
			if($tempArray[$key]['id'] == $get){
				unset($tempArray[$key]);

			}
		}	
		$tempArray = array_values($tempArray);
		$newJson = json_encode($tempArray);
		file_put_contents('carros.json', $newJson);
	}else{
		echo `Sem parametro`;	
	}
}

?>