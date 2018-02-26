<?php

class ajax_class {

	public function Sucesso($data = Array()) {

		global $tempoSala;

		header('Content-Type: application/json; charset=utf-8');

		$tempoSala->stop();

		$resposta = Array(
			'status' => 'sucesso',
			'tempoSala' => $tempoSala->getRenderTime()
		);

		$resposta = array_merge($resposta, $data);

		die(json_encode($resposta, JSON_ENCODE_FLAGS));

	}

	public function sucessoRegistros($registros, $total = null, $extras = Array()) {

		global $tempoSala;

		header('Content-Type: application/json; charset=utf-8');

		$tempoSala->stop();

		$resposta = Array(
			'status' => 'sucesso',
			'registros' => $registros,
			'tempoSala' => $tempoSala->getRenderTime(),
			'total' => is_null($total) ? count($registros) : $total
		);

		$resposta = array_merge($resposta, $extras);

		die(json_encode($resposta, JSON_ENCODE_FLAGS));

	}

	public function sucessoRegistro($registro, $extras = Array()) {

		global $tempoSala;

		header('Content-Type: application/json; charset=utf-8');

		$tempoSala->stop();

		$resposta = Array(
			'status' => 'sucesso',
			'tempoSala' => $tempoSala->getRenderTime(),
			'registro' => $registro
		);

		$resposta = array_merge($resposta, $extras);

		die(json_encode($resposta, JSON_ENCODE_FLAGS));

	}

	public function Erro($mensagem = null, $extra = Array()) {

		global $tempoSala;

		header('Content-Type: application/json; charset=utf-8');

		$tempoSala->stop();

		$resposta = Array(
			'status' => 'erro',
			'tempoSala' => $tempoSala->getRenderTime()
		);

		if(!empty($mensagem)) $resposta['mensagem'] = $mensagem;
		$resposta = array_merge($resposta, $extra);

		die(json_encode($resposta, JSON_ENCODE_FLAGS));

	}

}

$ajax = new ajax_class;

?>