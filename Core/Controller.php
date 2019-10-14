<?php
/**
 * @author Werberson <werberson@gmail.com>
 * @package Core
 */
namespace Core;

class Controller 
{

	/**
	 * Função que renderiza uma página na tela
	 *
	 * @param string $view
	 * @param array $data
	 * @return void
	 */
	public function render($view, $data = array())
	{
		extract($data);
		require 'Views/'.$view.'.php';
	}

	/**
	 * Função que retorna o método HTTP
	 *
	 * @return void
	 */
	public function getMethod() 
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Função que pega os dados passados por parâmetro
	 *
	 * @return void
	 */
	public function getRequestData() {
		
		switch($this->getMethod()) {
			case 'GET':
				return $_GET;
				break;
			case 'PUT':
				
			case 'DELETE':
				parse_str(file_get_contents('php://input'), $data);
				return (array) $data;
				break;

			case 'POST':
				$data = json_decode(file_get_contents('php://input'));
				if(is_null($data)) {
					$data = $_POST;
				}
				return (array) $data;
				break;
		}

	}

	/**
	 * Função para retornar o resultado em formato json
	 *
	 * @param array $array
	 * @return void
	 */
	public function returnJson($array) {
		header("Content-Type: application/json");		
		echo json_encode($array);
		exit;
	}

}










