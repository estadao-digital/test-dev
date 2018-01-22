<?php

class Carromodel extends CI_Model {
	
	public $urlfilemarcas = "application/models/db/marca.json";
	public $urlfilecarros = "application/models/db/modelo.json";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function list_marcas() {
		
		$str_data = file_get_contents($this->urlfilemarcas);
		$data = json_decode($str_data);
		
		return $data;
	}
	
	//Pega todos os dados da marca
	public function list_carros() {
		
		$str_data_marcas = file_get_contents($this->urlfilemarcas);
		$str_data_carros = file_get_contents($this->urlfilecarros);
		
		$data_marcas = json_decode($str_data_marcas);
		$data_carros = json_decode($str_data_carros);
		
		foreach($data_carros as $key => $row){
			//---------------------------Brands---------------------------//
			//Id da marca no arquivo marca.json
			$id_brand             = $data_carros[$key]->marca_id;
			//Pega id da marca relacionado ao id brand no arquivo marca.json
			$getBrandsKey         = $this->searchForId($id_brand, $data_marcas);
			//Inseri a key marca com todos os dados da marca no array data_carros
			$data_carros[$key]->marcas = $data_marcas[$getBrandsKey];
		}
		
		return $data_carros;
	}
	
	public function get_by_id_carro($id) {
		$str_data_marcas = file_get_contents($this->urlfilemarcas);
		$str_data_carros = file_get_contents($this->urlfilecarros);
		
		$data_marcas = json_decode($str_data_marcas);
		$data_carros = json_decode($str_data_carros);
		
		foreach($data_carros as $key => $row){
			//---------------------------Brands---------------------------//
			//Id da marca no arquivo modelo.json
			$id_brand             = $data_carros[$key]->marca_id;
			//Pega id da marca relacionado ao marca_id no arquivo modelo.json
			$getBrandsKey         = $this->searchForId($id_brand, $data_marcas);
			//Inseri a key marcas com os dados da marca no array data_carros
			$data_carros[$key]->marcas = $data_marcas[$getBrandsKey];
		}
		
		foreach($data_carros as $key =>  $row){
			//Retornar apenas o array com o id do modelo
			if($row->id == $id){
				return $data_carros[$key];
			}
		}
	}
	
	public function add_carro($message) {
		
		// read json file
		$data = file_get_contents($this->urlfilecarros);
		
		// decode json
		$json_arr = json_decode($data, true);
		$id = count($json_arr);
		$id++;
		$message = array(
			'id'    => $id,
			'marca_id' => (int)$message['marca'],
			'name'  => $message['name'],
			'ano'   => $message['ano']
		);
		
		// add data
		$json_arr[] = $message;
		
		// encode json and save to file
		file_put_contents($this->urlfilecarros, json_encode($json_arr));
		return 1;
	}
	
	public function update_carro($message) {
		
		// read file
		$data = file_get_contents($this->urlfilecarros);
		$id = $message['id'];

		// decode json to array
		$json_arr = json_decode($data, true);
		
		foreach ($json_arr as $key => $row) {
			if ($row['id'] == $id) {
				$json_arr[$key]['marca_id'] = (int)$message['marca'];
				$json_arr[$key]['name'] = $message['name'];
				$json_arr[$key]['ano'] = $message['ano'];
			}
		}

		// encode array to json and save to file
		file_put_contents($this->urlfilecarros, json_encode($json_arr));
		return 1;
	}
	
	public function delete_carro($message) {
		
		$id = (int)$message['id'];
		// read json file
		$data = file_get_contents($this->urlfilecarros);

		// decode json to associative array
		$json_arr = json_decode($data, true);

		// get array index to delete
		$arr_index = array();
		foreach ($json_arr as $key => $value)
		{
			if ($value['id'] == $id)
			{
				$arr_index[] = $key;
			}
		}

		// delete data
		foreach ($arr_index as $i)
		{
			unset($json_arr[$i]);
		}
		// rebase array
		$json_arr = array_values($json_arr);

		// encode array to json and save to file
		file_put_contents($this->urlfilecarros, json_encode($json_arr));
		return 1;
	}
	
	function searchForId($id, $array) {
		foreach ($array as $key => $val) {
			if ($val->id === $id) {
				return $key;
			}
		}
		return null;
	}
	
}