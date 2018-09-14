<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
        parent::__construct();

        //Model
        $this->load->model('carro_model');
    }

	public function index(){

		$this->data['list_carro'] = $this->carro_model->list_carro();

		$this->load->view('template/frontend/header');
		$this->load->view('frontend/home', $this->data);
		$this->load->view('template/frontend/footer');
	}
	public function getCarro($idCarro){

		$this->data['list_carro'] = $this->carro_model->get_carro($idCarro);
		$this->data['result'] = true;

		header('Content-Type: application/json');
        echo json_encode($this->data);

	}

	public function deleteCarro($idCarro){

		$this->data['result'] = $this->carro_model->delete_carro($idCarro);

		$this->data['list_carro'] = $this->carro_model->list_carro();

		header('Content-Type: application/json');
        echo json_encode($this->data);
	}

	public function addCarro(){
		$objData = new stdClass();
        $objData = (object)$_POST;

        $this->data['result'] = $this->carro_model->add_carro($objData);

		header('Content-Type: application/json');
        echo json_encode($this->data);
	}

	public function attCarro(){
		$objData = new stdClass();
        $objData = (object)$_POST;

        $this->carro_model->att_carro($objData);
        $this->data['result'] = true;

		header('Content-Type: application/json');
        echo json_encode($this->data);
	}
}
