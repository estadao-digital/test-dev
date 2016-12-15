<?php
/**
* Classe do carro
*/
class Carro {
	private $conexao;

	function __construct() {
		try {
	    	$this->conexao = new PDO('sqlite:carro.sqlite3');
	    	$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conexao->exec("CREATE TABLE IF NOT EXISTS carros ( id INTEGER PRIMARY KEY, marca TEXT, modelo TEXT, ano TEXT)");
		} catch (Exception $e) {
			// tratamento de erros
			var_dump($e);
			die();
		}
	}

	public function gravaCarro($post) {
		$dadosEsperados = array('marca','modelo','ano');
		foreach ($dadosEsperados as $ch => $valor) {
			if(!isset($_POST[$valor])) return ['erro' => 'falta um parametro :: '.$valor];
		}
		$stmt = $this->conexao->prepare("INSERT INTO carros (marca, modelo, ano) VALUES (:marca, :modelo, :ano)");
		$resultado = $stmt->execute(array(':marca' => $_POST['marca'], ':modelo' => $_POST['modelo'], ':ano' => $_POST['ano']));
		return ['resultado' => $resultado];
	}

	public function atualizaCarro($id) {
		$intId = intval($id);
		$res = $this->conexao->query("SELECT * FROM carros WHERE id = $intId");
		if ($res->fetchColumn() < 1) return ['erro' => 'item não existe para ser atualizado'];

		$input = json_decode(file_get_contents('php://input'),true);
		$dadosEsperados = array('marca','modelo','ano');
		foreach ($dadosEsperados as $ch => $valor) {
			if(!isset($input[$valor])) return ['erro' => 'falta um parametro :: '.$valor];
		}
		$stmt = $this->conexao->prepare("UPDATE carros SET marca = :marca, modelo = :modelo, ano = :ano WHERE id = :id");
		$resultado = $stmt->execute(array(':marca' => $input['marca'], ':modelo' => $input['modelo'], ':ano' => $input['ano'], ':id' => $id));
		return ['resultado' => $resultado];
	}

	public function deletaCarro($id) {
		$intId = intval($id);
		$stmt = $this->conexao->prepare("DELETE FROM carros WHERE id = :id");
		$resultado = $stmt->execute(array(':id' => $id));
		return ['resultado' => $resultado];
	}

	public function mostraCarro($id) {
		$intId = intval($id);
		$stmt = $this->conexao->query("SELECT * FROM carros WHERE id = $intId");
		$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function listaCarros() {
		$stmt = $this->conexao->query('SELECT * FROM carros');
		$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

}
?>
