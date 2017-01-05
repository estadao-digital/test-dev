<?php

require_once 'Crud.php';

class Carros extends Crud {
	
	protected $table = 'carros';
	private $marca;
	private $modelo;
	private $ano;

	public function getmarca(){
		return $this->marca;
	}

	public function getmodelo(){
		return $this->modelo;
	}

	public function getano(){
		return $this->ano;
	}

	public function setmarca($marca){
		$this->marca = $marca;
	}

	public function setmodelo($modelo){
		$this->modelo = $modelo;
	}

	public function setano($ano){
		$this->ano = $ano;
	}

	// Insere o carro
	public function insert(){
		$sql  = "INSERT INTO $this->table (marca, modelo, ano) VALUES (:marca, :modelo, :ano)";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(':marca', $this->marca);
		$stmt->bindParam(':modelo', $this->modelo);
		$stmt->bindParam(':ano', $this->ano);

		return $stmt->execute(); 
	}

	//Altera o carro
	public function update($id){
		$sql  = "UPDATE $this->table SET marca = :marca, modelo = :modelo, ano = :ano WHERE id = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(':marca', $this->marca);
		$stmt->bindParam(':modelo', $this->modelo);
		$stmt->bindParam(':ano', $this->ano);
		$stmt->bindParam(':id', $id);

		return $stmt->execute();
	}

}