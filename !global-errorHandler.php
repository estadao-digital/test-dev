<?php

function errosPersonalizados($errno, $errstr, $errfile, $errline, $errcontext) {

	global $tempoSala;

	$resposta = Array();
	$resposta['status'] = 'erro';
	$resposta['mensagem'] = $errstr;

	if(ERRORHANLER_TRACE == true) { // Responde com o trajeto do erro

		$resposta['errfile'] = $errfile;
		$resposta['errline'] = $errline;
		$resposta['trace'] = debug_backtrace();
		array_shift($resposta['trace']);
		$resposta['trace'] = array_reverse($resposta['trace']);

	}

	$tempoSala->stop();

	$resposta['tempoSala'] = $tempoSala->getRenderTime();

	$jsonResposta = json_encode($resposta);

	if(empty($jsonResposta)) { // Se houver alguma falha na codigicação da resposta, tenta novamente adicionando o parâmetro DEBUG_BACKTRACE_IGNORE_ARGS na função debug_backtrace()

		$resposta['trace'] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		array_shift($resposta['trace']);
		$resposta['trace'] = array_reverse($resposta['trace']);
		$jsonResposta = json_encode($resposta);

	}

	header('Content-type: application/json; charset=UTF-8');

	print $jsonResposta;

	exit;
}

set_error_handler('errosPersonalizados');

?>