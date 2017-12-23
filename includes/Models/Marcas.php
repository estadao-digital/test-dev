<?php

class Marcas_Models{
		
	public function getData()
	{
		$marcasJson = $this->getFile();
		
		$data = json_decode(file_get_contents($marcasJson), true);
		return $data;
	}
	public function getDataAjax()
	{
		$marcasJson = $this->getFile();
		
		$data = file_get_contents($marcasJson);
		return $data;
	}
	public function getFile()
	{		
		$dataDir = $_SESSION['dir'].'/data/';
		$file = $dataDir.'marcas.json';
		return $file;
	}
	public function saveData($data)
	{
		$marcasJson = $this->getFile();
		
		$file = fopen($marcasJson, 'w');
		fwrite($file, json_encode($data));
		fclose($file);
	}
	
}