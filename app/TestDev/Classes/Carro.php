<?php

namespace TestDev\Classes;


/**
 * Class name Car, O references to Object
 */

class Carro
{

 /**
 * @author Lucas <lucas.c.victor@hotmail.com>
 **/

 	protected $id;
 	protected $marca;
 	protected $modelo;
 	protected $ano;

 	public function getId() {
 		return $this->id;
 	}

 	public function setId($id) {
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

 	public function setAno($ano) {
 		$this->ano = $ano;
 	}



}