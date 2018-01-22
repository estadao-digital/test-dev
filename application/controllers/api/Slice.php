<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Slice extends REST_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model("carromodel");
	}
	
	public function carros_get()
	{
		$selectmarcas = $this->carromodel->list_carros();
		
		$id = $this->get('id');
		
		if ($id === NULL)
		{
			if ($selectmarcas)
			{
				$this->response($selectmarcas, REST_Controller::HTTP_OK); // OK (200)
			}
			else
			{
				$this->response([
					'status' => FALSE,
					'message' => 'Carros não encontrados.'
				], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
		
		// Se a existi um ID, exibir apenas o carro referente ao ID.
		$id = (int) $id;
		
		// Valida o id.
		if ($id <= 0)
		{
			// Se id inválido exibe o erro 400.
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
		
		// Obter o carro referente ao id inserido
		$selectmarca = NULL;
		
		if (!empty($selectmarcas))
		{
			foreach ($selectmarcas as $key => $value)
			{
				if (isset($value->id) && $value->id === $id)
				{
					$selectmarca = $value;
				}
			}
		}
		
		if (!empty($selectmarca))
		{
			$this->set_response($selectmarca, REST_Controller::HTTP_OK); // OK (200)
		}
		else
		{
			$this->set_response([
				'status' => FALSE,
				'message' => 'Carro não encontrado.'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404)
		}
	}
	
	public function carros_post()
	{
		$message = array(
			'name' => $this->post('name'),
			'marca' => $this->post('marca'),
			'ano' => $this->post('ano')
		);
		
		$addmodelo = $this->carromodel->add_carro($message);
		
		if($addmodelo == 1){
			$this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201)
		}else{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
	}
	
	public function carros_put()
	{
		$id       =  $this->put('id');
		$marca_id =  $this->put('marca');
		
		if(!is_numeric($id)){
			$message = array(
				'mensagem'    => "Campo id precisar ser (INT)"
			);
			
			$this->response($message, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}elseif(!is_numeric($marca_id)){
			$message = array(
				'mensagem'    => "Campo marca precisar ser (INT)"
			);
			
			$this->response($message, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
		
		if(!empty($id) && !empty($marca_id) ){
			
			$message = array(
				'id'    => $this->put('id'),
				'name'  => $this->put('name'),
				'marca' => $this->put('marca'),
				'ano'   => $this->put('ano')
			);
			
			$editmodelo = $this->carromodel->update_carro($message);
			
			if($editmodelo == 1){
				$this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201)
			}else{
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
			}
			
		}else{
			
			$message = array(
				'mensagem'    => "Campo id precisar ser (INT)"
			);
			
			$this->response($message, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
		
		
	}
	
	public function carros_delete()
	{
		$id = $this->delete('id');
		
		if(!is_numeric($id)){
			$message = array(
				'mensagem'    => "Campo id precisar ser (INT)"
			);
			
			$this->response($message, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
		
		// Validate the id.
		if ($id <= 0)
		{
			// Set the response and exit
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
		
		$message = [
			'id' => $id
		];
		
		$deletemodelo = $this->carromodel->delete_carro($message);
		
		if($deletemodelo == 1){
			
			$this->set_response(null, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204)
		}else{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
		
	}
	
}
