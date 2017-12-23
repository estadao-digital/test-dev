<?php

class Carros_Models{
		
	public function getData()
	{
		$carrosJson = $this->getFile();
		
		$data = json_decode(file_get_contents($carrosJson), true);
		return $data;
	}
	public function getFile()
	{		
		$dataDir = $_SESSION['dir'].'/data/';
		$file = $dataDir.'data.json';
		return $file;
	}
	public function saveData($data)
	{
		$dir = $this->getFile();
		$carrosJson = $this->getData();
		$i = 0;
		foreach($carrosJson as $key => $value)
		{
			if($carrosJson[$key]['id'] == $data['id'])
			{
				$carrosJson[$key]['modelo'] = $data['modelo'];
				$carrosJson[$key]['ano'] = $data['ano'];
				$carrosJson[$key]['marca'] = $data['marca'];
			}
			$i++;
		}
		
		$file = fopen($dir, 'w');
		fwrite($file, json_encode($carrosJson));
		fclose($file);
	}
	public function addIdAi()
	{
		$dir = $this->getFile();
		$idAiFile = str_replace('data.json','id_ai.txt',$dir);
		$idAi = file_get_contents($idAiFile);
				
		$idAi++;
			
		$file = fopen($idAiFile, 'w');
		fwrite($file, $idAi);
		fclose($file);
		
		return $idAi;
	}
	public function getIdAi()
	{
		$dir = $this->getFile();
		$idAiFile = str_replace('data.json','id_ai.txt',$dir);
		$idAi = file_get_contents($idAiFile);
		
		return $idAi;
	}
	public function deleteData($id)
	{
		$dir = $this->getFile();
		$carrosJson = $this->getData();
		foreach($carrosJson as $key => $value)
		{
			if($carrosJson[$key]['id'] == $id)
			{
				unset($carrosJson[$key]);
			}
		}
		$file = fopen($dir, 'w');
		fwrite($file, json_encode($carrosJson));
		fclose($file);
	}
	public function insertData($data)
	{
		$dir = $this->getFile();
		$carrosJson = $this->getData();
		$i = 0;
		$data['id'] = $this->addIdAi();
		array_push($carrosJson, $data);
		
		$file = fopen($dir, 'w');
		fwrite($file, json_encode($carrosJson));
		fclose($file);
	}
	
}

?>