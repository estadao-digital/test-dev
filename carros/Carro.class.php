<?php

include_once 'Data.class.php';

# A classe Carro realiza a chamada a classe de persistência de dados (Data) e retorna ou seta seus respectivos valores

class Carro 
{
	private $file;
	private $data;
	private $id;

	public function __construct($file) 
	{
		$this->file = $file;
	}

	public function getValues()
	{
		$retorno = (new Data($this->file))->consultarCadastrados();
		return $retorno;
	}

	public function getValueID($id)
	{
		$this->id = $id;
		$retorno = (new Data($this->file))->consultarID($this->id);
		return $retorno;
	}

	public function setValue($array_data)
	{
		$this->data = $array_data;
		$gravar_banco = (new Data($this->file))->inserirPost($this->data);
		return $gravar_banco;
	}

	public function atualizaValue($array_data)
	{
		$this->data = $array_data;
		$atualizar_banco = (new Data($this->file))->atualizarPut($this->data);
		return $atualizar_banco;
	}

	public function deletarValue($array_data)
	{
		$this->data = $array_data;
		$deletarID_banco = (new Data($this->file))->excluirDelete($this->data);
		return $deletarID_banco;
	}
}
