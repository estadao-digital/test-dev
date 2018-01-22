<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Home extends REST_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model("carromodel");
		
	}
	
	public function carros_get()
	{
		$data['selectmarcas'] = $this->carromodel->list_marcas();
		$data['selectcarros'] = $this->carromodel->list_carros();
		
		$this->load->view('home', $data);
	}
	
	public function carros_ajax_get()
	{
		$data['selectmarcas'] = $this->carromodel->list_marcas();
		$this->load->view("template_ajax/add", $data);
	}
	
	public function edit_carros_ajax_get()
	{
		$data['selectmarcas']     = $this->carromodel->list_marcas();
		$data["selectcarrosById"] = $this->carromodel->get_by_id_carro($this->get('id'));
		$data['id']               = $this->get('id');
		
		$this->load->view("template_ajax/edit", $data);
	}
	
	public function voltar_carros_ajax_get()
	{
		$this->load->view("template_ajax/list");
	}
	
	public function carros_ajax_add_post()
	{
		
		$is_ajax = $this->input->is_ajax_request();
		
		if($is_ajax){
			//$this->some_model->update_user( ... );
			$message = [
				'id' => 100,
				'name' => $this->post('name'),
				'marca' => $this->post('marca'),
				'ano' => $this->post('ano')
			];
			
			$this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201)
			
			$selectmarcas         = $this->carromodel->list_marcas();
		
			$data['selectmarcas'] = $selectmarcas;
		
			
			$this->load->view('template_ajax/add', $data);
		}else{
			// Set the response and exit
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
	}
	
	
}