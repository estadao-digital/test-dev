<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AcoesModel extends CI_Model{
    
    var $file = 'carro';
    
    public function criar($data){
        $return = $this->BaseModel->criar($this->file,$data);
        return $return;
    }
    
    public function alterar($idUsuario, $data){
        $return = $this->BaseModel->alterar($this->file, $idUsuario, $data);
        return $return;
    }
    
    public function deletar($idUsuario){
        $return = $this->BaseModel->deletar($this->file, $idUsuario);
        return $return;
    }
    
    public function ler($arrData = array()){
        $return = $this->BaseModel->ler($this->file,$arrData);
        return $return;
    }
}

