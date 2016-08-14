<?php

# classe utilizada para realizar persistência no arquivo .json

class Data 
{
	private $file;
	private $array_data;
	private $array_new_data;
	private $status;
	private $id;

	public function __construct($file) 
	{
		$this->file = $file;
	}

	public function consultarCadastrados()
	{
		$retorno = file_get_contents($this->file);
		return $retorno;
	}

	public function consultarID($id)
	{
		$this->id = $id;
		$consulta = json_decode((new Carro($this->file))->getValues(), true);

		foreach ($consulta['carros'] as $carro) {
			if($carro['id'] == $this->id){
				return json_encode($carro);
				break;
			}
		}
	}

	public function inserirPost($data) 
	{
		$this->status = "POST-OK";
		$this->array_data = $data;

		$consulta = json_decode((new Carro($this->file))->getValues(), true);
		$array_temp_marcas = $consulta['marcas'];
		$count_array = count($consulta['carros']);

		if($count_array == 0)
		{
			$maior_id = 0;
		}
		else
		{
			for($i = 0; $i < $count_array; $i++)
			{
				if($i == 0){
					$maior_id = $consulta['carros'][$i]['id'];
				} 
				elseif($consulta['carros'][$i]['id'] > $maior_id)
				{
					$maior_id = $consulta['carros'][$i]['id'];
				}
			}
		}

		$array_tem = array(
			'id'=> $maior_id + 1,
			'Modelo'=>$this->array_data['modelo'],
			'Marca'=>$this->array_data['marca'],
			'Ano'=>$this->array_data['ano']
		);

		sort($consulta['carros']);
		$array_temp_carros = $consulta['carros'];
		$array_temp_carros[] = $array_tem;

		$this->array_new_data = array(
			'marcas'=> $array_temp_marcas, 
			'carros'=> $array_temp_carros
		);

		return $this->persistencia();
	}

	public function atualizarPut($data) 
	{
		$this->status = "PUT-OK";
		$this->array_data = $data;

		$consulta = json_decode((new Carro($this->file))->getValues(), true);
		$array_temp_marcas = $consulta['marcas'];

		$count_array = count($consulta['carros']);

		for($i = 0; $i < $count_array; $i++)
		{
			if($consulta['carros'][$i]['id'] == $this->array_data['id'])
			{
				$consulta['carros'][$i]['Modelo'] = $this->array_data['modelo'];
				$consulta['carros'][$i]['Marca'] = $this->array_data['marca'];
				$consulta['carros'][$i]['Ano'] = $this->array_data['ano'];
				break;
			}
		}

		sort($consulta['carros']);
		$array_temp_carros = $consulta['carros'];

		$this->array_new_data = array(
			'marcas'=> $array_temp_marcas, 
			'carros'=> $array_temp_carros
		);

		return $this->persistencia();

	}

	public function excluirDelete($data) 
	{
		$this->status = "DELETE-OK";
		$this->array_data = $data;

		$consulta = json_decode((new Carro($this->file))->getValues(), true);
		$array_temp_marcas = $consulta['marcas'];
		$count_array = count($consulta['carros']);

		for($i = 0; $i < $count_array; $i++)
		{
			if($consulta['carros'][$i]['id'] == $this->array_data['id'])
			{
				unset($consulta['carros'][$i]);
				break;
			}
		}
		
		sort($consulta['carros']);
		$array_temp_carros = $consulta['carros'];

		$this->array_new_data = array(
			'marcas'=> $array_temp_marcas, 
			'carros'=> $array_temp_carros
		);

		return $this->persistencia();

	}

	private function persistencia()
	{
		if(is_writable($this->file))
		{
			$f = fopen($this->file, 'w');
			fwrite($f, json_encode($this->array_new_data));
			fclose($f);
			return $this->status;
		}
	}

}
