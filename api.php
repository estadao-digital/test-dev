<?php

//
// Includes
//

require('!global-include.php');

// *************** ATENÇÃO *************************************************
//sleep(2); // Esperar 2 segundos de propósito para ver a interface carregando
// *************** ATENÇÃO *************************************************

//
// Parâmetros
//

$modulo = &$_GET['modulo'];
$acao = &$_GET['acao'];
$id = &$_GET['id'];

if(empty($modulo)) trigger_error('Necessário informar o nome do módulo', E_USER_ERROR);
if(empty($acao)) trigger_error('Necessário informar a ação', E_USER_ERROR);
if(!empty($id) && !is_numeric($id)) trigger_error('Parâmetro ID inválido', E_USER_ERROR);

// Alguma proteção se algum experto chamar direto pelo api.php, sem passar pelo RewriteRule

$acao = addslashes($acao);
$acao = strip_tags($acao);
$acao = strtoupper($acao);
$modulo = addslashes($modulo);
$modulo = strip_tags($modulo);
$modulo = strtoupper($modulo);

//
// Ações
//

switch($modulo) {

	case 'CARROS':

		require('Carro.class.php');
		$carro = new carro_class;

		switch($acao) {

			case 'GET':

				if(empty($id)) {

					$registros = $carro->Listar();
					$ajax->sucessoRegistros($registros);

				}else{

					$registro = $carro->Obter($id);
					$ajax->sucessoRegistro($registro);

				}

			break;
			case 'PUT':

				parse_str(file_get_contents('php://input'), $registro);

				if(empty($registro)) trigger_error('Necessário informar os campos do registro a ser gravado', E_USER_ERROR);

				$resposta = $carro->Incluir($registro);

				if($resposta->ok == true) {
					$ajax->Sucesso();
				}else{
					$ajax->Erro($resposta->mensagem);
				}

			break;
			case 'POST':

				$registro = &$_POST;

				if(empty($registro)) trigger_error('Necessário informar os campos do registro a ser alterado', E_USER_ERROR);

				$resposta = $carro->Alterar($registro);

				if($resposta->ok == true) {
					$ajax->Sucesso();
				}else{
					$ajax->Erro($resposta->mensagem);
				}

			break;
			case 'DELETE':

				if(empty($id)) trigger_error('Necessário informar a identificação numérica do registro à excluir', E_USER_ERROR);
				$resposta = $carro->Excluir($id);

				if($resposta->ok == true) {
					$ajax->Sucesso();
				}else{
					$ajax->Erro($resposta->mensagem);
				}

			break;
			default:

				trigger_error('Ação '.$acao.' não implementada para o módulo '.$modulo, E_USER_ERROR);

			break;

		}

	break;

	case 'CARROS/ENUMERACAO':

		require('Carro.class.php');
		$carro = new carro_class;

		switch($acao) {

			case 'GET':

				$resposta = Array();
				$resposta['marcas'] = $carro->obterEnumerador('marcas');
				$ajax->sucessoRegistro($resposta);

			break;

			default:

				trigger_error('Ação '.$acao.' não implementada para o módulo '.$modulo, E_USER_ERROR);

			break;

		}

	default:

		trigger_error('Módulo '.$modulo.' não implementado', E_USER_ERROR);

	break;
}

trigger_error('Ação '.$acao.' do módulo '.$modulo.' não possui parada. Contate o suporte do software.', E_USER_ERROR);

?>