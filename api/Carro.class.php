<?php

/**
* Classe do carro
*/

class Carro
{
	// Propriedades
	private $id;
	private $marca;
	private $modelo;
    private $ano;

    private $method;
    
	function __construct($marca = '', $modelo = '', $ano = '')
	{
		$this->marca = $marca;
		$this->modelo = $modelo;
		$this->ano = $ano;
	}

	function verifyMethod($method, $route){
        
        // Verifica o método enviado
		switch ($method) {

		case 'GET':
			// Retorna um carro
			return self::doGet($route);
            break;
            
		case 'POST':
			// Incluir um carro
			if(empty($route[1])){
				return self::doPost();
			}else{
				return $arr_json = array('status' => 404);
			} 
            break;
            
		case 'PUT':
			// Atualiza um carro
			return self::doPut($route); 
            break;
            
		case 'DELETE':
			// Exclui um carro
			return self::doDelete($route); 
            break;		
            
		default:
			// Caso seja informado um método inexistente, retorna um erro
			return array('status' => 405);
      		break;
		}

	}

	function doGet($route){
		
		// Pega o conteúdo do JSON
		$temp = file_get_contents('database.json');

		// Decodifica o conteúdo para um array
		$json = json_decode($temp, TRUE);

		// Caso a busca seja pra um registro especifico
		if($route[1] != ""){

			// Acessa função que busca somente o carro desejado
			$registro = self::getCarroById($json, $route[1]);
			$json = $registro;
		} 

		return $json;
        
    }
    
	function doPost(){
		
		// Pega o conteúdo do JSON
		$temp = file_get_contents('database.json');

		// Decodifica o conteúdo para um array
		$temp = json_decode($temp, TRUE);

		// Último ID
		if(!empty($temp)) {
			$ultimoItem = end($temp);
			$ultimoId = $ultimoItem['id'];
		} else {
			$ultimoId = 0;
		}
		
		// Dados que serão gravados no JSON
		$dados = array(
			'id' => ++$ultimoId,
			'marca' => $this->marca,
			'modelo' => $this->modelo,
			'ano' => $this->ano,
		);

		// Insere as novas informações no array
		$temp[] = $dados;
		
		// Transforma o conteúdo do array em JSON
		file_put_contents('database.json', json_encode($temp));
		
		return $dados;
		
    }
    
	function doPut($route){

		// Pega o conteúdo do JSON
		$temp = file_get_contents('database.json');

		// Decodifica o conteúdo para um array
		$temp = json_decode($temp, TRUE);

		// Identifica a chave do registro que será apagado
		$key = self::getKey($temp, $route[1]);

		// Acessa função que busca somente o carro desejado
		$temp[$key] = [
			'id' => $route[1],
			'marca' => $this->marca,
			'modelo' => $this->modelo,
			'ano' => $this->ano,
		];

		// Transforma o conteúdo do array em JSON
		file_put_contents('database.json', json_encode($temp));
	
		return $temp;

    }
    
	function doDelete($route){
		
		// Pega o conteúdo do JSON
		$temp = file_get_contents('database.json');

		// Decodifica o conteúdo para um array
		$temp = json_decode($temp, TRUE);

		foreach($temp as $index => $carro) {
			if($carro['id'] == $route[1]) {
				unset($temp[$index]);
			}
		}

		print_r($temp);

		// Transforma o conteúdo do array em JSON
		file_put_contents('database.json', json_encode($temp));

		return $temp;

	}

	/**
	 * Função para buscar um carro especifico (por ID) dentro de um JSON
	 * return @array (registro do carro)
	 */
	function getCarroById($array, $id) {
		
		foreach($array AS $index=>$json) {
			if($json['id'] == $id) {
				return $json;
			}
		}
	}

	/**
	 * Função para buscar o indice do carro dentro de um JSON
	 * return @integer key
	 */
	function getKey($array, $id) {
		
		foreach($array AS $index=>$json) {
			if($json['id'] == $id) {
				return $index;
			}
		}
	}
}

?>