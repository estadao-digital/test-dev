<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acoes extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array('AutenticacaoModel', 'AcoesModel', 'BaseModel'));
        $this->load->helper(array('json_output','data','mensagempt'));
    }

    private function proximoId(){
        $arrSearch = $this->AcoesModel->ler();
        if (is_array($arrSearch) AND !empty($arrSearch['carros'])){
            foreach ($arrSearch['carros'] as $values){
                foreach ($values as $key => $value){
                    if($key == "id"){
                        $arrValue[] = $value;
                    }
                }
            }
            $return = max($arrValue) + 1;
        }
        else{
            $return =  1;
        }
        return $return;
    }

    public function ler($id = null){
        $metodo = $_SERVER['REQUEST_METHOD'];
        $respStatus = 400;
        $resp = erroPadrao();
        if($metodo != 'GET'){
            $resp = erroRequisicao();
        }
        else{
            $autenticacaoCliente = $this->AutenticacaoModel->autenticacaoCliente();
            if($autenticacaoCliente == true){
                if($this->AutenticacaoModel->autenticacao()){
                    $respStatus = 200;
                    $arrData = (!empty($id) ? array('id'=>$id) : null);
                    $respRead = $this->AcoesModel->ler($arrData);
                    $resp = array('status' => $respStatus, $respRead);
                }
                else{
                    $resp = naoAutorizado();
                }
            }
            else{
                $resp = naoAutorizado();
            }
        }
        json_output($respStatus,$resp);
    }

    public function criar(){
        $metodo = $_SERVER['REQUEST_METHOD'];
        $respStatus = 400;
        $resp = erroPadrao();
        if($metodo != 'POST'){
            $resp = erroRequisicao();
        }
        else{
            $autenticacaoCliente = $this->AutenticacaoModel->autenticacaoCliente();
            if($autenticacaoCliente == true){
                if($this->AutenticacaoModel->autenticacao()){
                    $params = json_decode(file_get_contents('php://input'), TRUE);

                    if ($params['Marca'] == "" || $params['Modelo'] == "" || $params['Ano'] == ""){
                        $resp = dadosIncompletos();
                    }
                    else{
                        if ($proximoId = $this->proximoId()){
                            $params['id'] = $proximoId;
                            $params['create_at'] = pegarDataHoraAtual();
                            if ($this->AcoesModel->criar($params)){
                                $respStatus = 200;
                                $resp = sucessoUsuarioId($proximoId);
                            }
                            else{
                                $resp = erroInserirCarro();
                            }
                        }
                        else{
                            $resp = erroGerarCarro();
                        }
                    }
                }
                else{
                    $resp = naoAutorizado();
                }
            }
            else{
                $resp = naoAutorizado();
            }
        }
        json_output($respStatus,$resp);
    }

    public function alterar($id){
        $metodo = $_SERVER['REQUEST_METHOD'];
        $respStatus = 400;
        $resp = erroPadrao();
        if($metodo != 'POST' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
            $resp = erroRequisicao();
        }
        else{
            $autenticacaoCliente = $this->AutenticacaoModel->autenticacaoCliente();
            if($autenticacaoCliente == true){
                if($this->AutenticacaoModel->autenticacao()){
                    $params = json_decode(file_get_contents('php://input'), TRUE);
                    if ($params['Marca'] == "" || $params['Modelo'] == "" || $params['Ano'] == ""){
                        $resp = dadosIncompletos();
                    }
                    else{
                        if ($respRead = $this->AcoesModel->ler( array('id' =>$id))){
                            if(count($respRead['carros']) > 0){
                                if ($this->AcoesModel->alterar($id, $params)){
                                    $respStatus = 200;
                                    $resp = sucesso();
                                }
                                else{
                                    $resp = erroAlterarCarro();
                                }
                            }
                            else{
                                $resp = carroInexistente();
                            }
                        }
                        else{
                            $resp = carroInexistente();
                        }
                    }
                }
                else{
                    $resp = naoAutorizado();
                }
            }
            else{
                $resp = naoAutorizado();
            }
        }
        json_output($respStatus,$resp);
    }

    public function deletar($id){
        $metodo = $_SERVER['REQUEST_METHOD'];
        $respStatus = 400;
        $resp = erroPadrao();
        if($metodo != 'POST' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
            $resp = erroRequisicao();
        } 
        else{
            $autenticacaoCliente = $this->AutenticacaoModel->autenticacaoCliente();
            if($autenticacaoCliente == true){
                if($this->AutenticacaoModel->autenticacao()){
                    if($this->AcoesModel->deletar($id)){
                        $respStatus = 200;
                        $resp = sucesso();
                    }
                    else{
                        $resp = erroDeletarCarro();
                    }
                }
                else{
                    $resp = naoAutorizado();
                }
            }
            else{
                $resp = naoAutorizado();
            }
        }
        json_output($respStatus,$resp);
    }
}
