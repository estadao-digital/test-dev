<?php

class Carro
{
	
	public $id;
	public $marca;
	public $modelo;
	public $ano;

	function __construct($id, $marca, $modelo, $ano)
	{
		$this->id = $id;
		$this->marca = $marca;
		$this->modelo = $modelo;
		$this->ano = $ano;
	}

	static function get_carro($id){

		if (!isset($_SESSION['carros'])){
			return FALSE;
		}else{
			foreach ($_SESSION['carros'] as $index => $carro) {
				if ($carro['id'] == $id) {
					$get_car = $_SESSION['carros'][$index];
				}
			}	
			return isset($get_car) ? $get_car : FALSE;
		}
	}

	static function get_carros(){

		return empty($_SESSION['carros']) ? FALSE : $_SESSION['carros'];
	}

	function insert_carro(){
		$_SESSION['carros'][] = array(
									'id'=>"$this->id",
									'marca'=>"$this->marca",
									'modelo'=>"$this->modelo",
									'ano'=>"$this->ano"
							);
	}

	static function update_carro($id, $marca, $modelo, $ano){
		foreach ($_SESSION['carros'] as $index => $carro) {
			if ($carro['id'] == $id) {
				$_SESSION['carros'][$index]['marca'] = $marca;
				$_SESSION['carros'][$index]['modelo'] = $modelo;
				$_SESSION['carros'][$index]['ano'] = $ano;
			}
		}	
		
	}

	static function delete_carro($id){

		foreach ($_SESSION['carros'] as $index => $carro) {
			if ($carro['id'] == $id) {
				unset($_SESSION['carros'][$index]);
			}
		}
	}

}

?>