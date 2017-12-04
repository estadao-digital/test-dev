<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AutenticacaoModel extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('data','mensagempt'));
    }

    var $client_service = "frontend-client";
    var $auth_key       = "simplerestapi";
    var $fileUser = 'carro';
    var $fileAuth = 'auth';

    public function autenticacaoCliente(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
            return true;
        } 
        else{
            return json_output(401,autorizado());
        }
    }

    public function autenticacao(){
        $token = $this->input->get_request_header('Authorization', TRUE);
        if ($arrResult = $this->verificarToken($token)){
            $arrResult['last_login'] = pegarDataHoraAtual();
            $arrResult['expired_at'] = somarData(1);
            $id = $arrResult['id'];
            $this->alterar($id, $arrResult);
            return true;
        }
        else{
            return false;
        }
    } 
    
    public function criar($data){
        $return = $this->BaseModel->criar($this->fileAuth,$data);
        return $return;
    }
    
    public function alterar($id, $data){
        $return = $this->BaseModel->alterar($this->fileAuth, $id, $data);
        return $return;
    }
    
    public function deletar($id){
        $return = $this->BaseModel->deletar($this->fileAuth, $id);
        return $return;
    }
    
    public function ler($arrData = array()){
        $return = $this->BaseModel->ler($this->fileAuth,$arrData);
        if (empty($return['carros'][0])){
            return false;
        }
        return $return;
    }
    
    public function verificarToken($token){
        $arrConsult['token'] = $token;
        if($arrResult = $this->ler($arrConsult)){
            if($arrResult['carros'][0]['expired_at'] > pegarDataAtual()){
                return $arrResult['carros'][0];
            }
        }
        return false;
    }   
}
