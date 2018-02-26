<?php
/**
* Classe do carro
*/

class carro_class {

	private function obterTabela($tabela) {

		return json_decode(file_get_contents('data/tabela.'.$tabela.'.json'), true);

	}

	private function gravarTabela($tabela, $conteudo) {

		return file_put_contents('data/tabela.'.$tabela.'.json', json_encode(array_values($conteudo), JSON_ENCODE_FLAGS));

	}

	public function obterEnumerador($enumeracao) {

		return json_decode(file_get_contents('data/enumeracao.'.$enumeracao.'.json'), true);

	}

	private function Falhar($mensagem) {

		$resposta = new stdClass;
		$resposta->ok = false;
		$resposta->mensagem = $mensagem;
		return $resposta;

	}

	private function ok() {

		$resposta = new stdClass;
		$resposta->ok = true;
		return $resposta;

	}

	public function Listar() {

		$marcas = $this->obterEnumerador('marcas');
		$registros = $this->obterTabela('carros');

		foreach($registros as &$registro) {
			$marcaIndex = array_search($registro['marca'], array_column($marcas, 'id'));
			if(isset($marcas[$marcaIndex])) $registro['marca'] = $marcas[$marcaIndex]['text'];
		}

		unset($registro);

		return $registros;

	}

	public function Obter($id) {

		if(empty($id)) return $this->Falhar('Necessário informar a identificação numérica do carro a ser excluído');
		if(!is_numeric($id)) return $this->Falhar('Parâmetro id inválido');

		$registros = $this->obterTabela('carros');
		$registroIndex = array_search($id, array_column($registros, 'id'));
		if($registroIndex === false) return false;
		return $registros[$registroIndex];

	}

	public function Incluir($registro) {

		if(!isset($registro['id']) || empty($registro['id'])) return $this->Falhar('Necessário informar a identificação numérica do carro');
		if(!isset($registro['marca']) || empty($registro['marca'])) return $this->Falhar('Necessário informar o fabricante/marca do carro');
		if(!isset($registro['modelo']) || empty($registro['modelo'])) return $this->Falhar('Necessário informar o modelo do carro');
		if(!isset($registro['ano']) || empty($registro['ano'])) return $this->Falhar('Necessário informar o ano de fabricação do carro');

		$registros = $this->obterTabela('carros');
		$registroIndex = array_search($registro['id'], array_column($registros, 'id'));
		if($registroIndex !== false) return $this->Falhar('Já existe o carro com identificação '.$registro['id']);
		$registros[] = $registro;
		$this->gravarTabela('carros', $registros);
		return $this->ok();
	}


	public function Alterar($registro) {

		if(!isset($registro['id']) || empty($registro['id'])) return $this->Falhar('Necessário informar a identificação numérica do carro');
		if(!isset($registro['marca']) || empty($registro['marca'])) return $this->Falhar('Necessário informar o fabricante/marca do carro');
		if(!isset($registro['modelo']) || empty($registro['modelo'])) return $this->Falhar('Necessário informar o modelo do carro');
		if(!isset($registro['ano']) || empty($registro['ano'])) return $this->Falhar('Necessário informar o ano de fabricação do carro');

		$registros = $this->obterTabela('carros');
		$registroIndex = array_search($registro['id'], array_column($registros, 'id'));
		if($registroIndex !== false) $registros[$registroIndex] = array_merge($registros[$registroIndex], $registro);
		$this->gravarTabela('carros', $registros);
		return $this->ok();

	}


	public function Excluir($id) {

		if(empty($id)) return $this->Falhar('Necessário informar a identificação numérica do carro a ser excluído');
		if(!is_numeric($id)) return $this->Falhar('Parâmetro id inválido');

		$registros = $this->obterTabela('carros');
		$registroIndex = array_search($id, array_column($registros, 'id'));
		if($registroIndex === false) return $this->Falhar('Carro '.$id.' não existe');
		unset($registros[$registroIndex]);
		$this->gravarTabela('carros', $registros);
		return $this->ok();

	}

}

?>