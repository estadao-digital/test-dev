<?php
/**
 * Classe do carro
 */
class Carro {
	private $id;
	private $marca;
	private $modelo;
	private $ano;
	function __construct() {
	}
	public function getID() {
		return $this->id;
	}
	public function setID($id) {
		$this->id = $id;
	}
	public function getMarca() {
		return $this->marca;
	}
	public function setMarca($marca) {
		$this->marca = $marca;
	}
	public function getModelo() {
		return $this->modelo;
	}
	public function setModelo($modelo) {
		$this->modelo = $modelo;
	}
	public function getAno() {
		return $this->ano;
	}
	public function toArray() {
		return array (
				"id" => $this->id,
				"marca" => $this->marca,
				"modelo" => $this->modelo,
				"ano" => $this->ano 
		);
	}
	public function getJsonString() {
		return json_encode ( $this->toArray () );
	}
	public static function getFromArray($arr) {
		if (array_has_key ( "id", $arr )) {
			$carro = new Carro ();
			$carro->id = $arr ["id"];
			$carro->marca = $arr ["marca"];
			$carro->modelo = $arr ["modelo"];
			$carro->ano = $arr ["ano"];
			return $carro;
		} else {
			$carros = array ();
			foreach ( $arr as $ar ) {
				$carro = new Carro ();
				$carro->id = $ar ["id"];
				$carro->marca = $ar ["marca"];
				$carro->modelo = $ar ["modelo"];
				$carro->ano = $ar ["ano"];
				$carros [] = $carro;
			}
			return $carros;
		}
		return null;
	}
}

?>