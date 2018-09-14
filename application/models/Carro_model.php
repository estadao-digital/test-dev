<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carro_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

    public function list_carro(){
        $this->db->select('CAR.intId, CAR.intAno, CAR.strModelo, CAR.strMarca');

        $this->db->from('tabCarro AS CAR');
            
        $this->db->order_by('CAR.intId', 'DESC');

        $get = $this->db->get();
        
        if($get->num_rows() >0)
            return $get->result();
        
        return array();
    }

    public function get_carro($idCarro){
        $this->db->select('CAR.intId, CAR.intAno, CAR.strModelo, CAR.strMarca');

        $this->db->from('tabCarro AS CAR');
            
        $this->db->where('CAR.intID', $idCarro);

        $get = $this->db->get();
        
        if($get->num_rows() >0)
            return $get->result();
        
        return array();    	
    }

    public function delete_carro($idCarro){

        $this->db->where('intId', $idCarro);

        return $this->db->delete('tabCarro');
    }

    public function add_carro($objCarro){
        $data = array(
            'intAno' => $objCarro->intAno,
            'strModelo' => $objCarro->strModelo,
            'strMarca' => $objCarro->strMarca
        );

        return $this->db->insert('tabCarro', $data);
    }

    public function att_carro($objCarro){

        $this->db->where('intId', $objCarro->intId);

        $this->db->update('tabCarro', $objCarro);
    }
}