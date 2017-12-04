<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticacao extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array('AutenticacaoModel', 'AcoesModel', 'BaseModel'));
        $this->load->helper(array('json_output','data','mensagempt'));
    }

    private function verificarLogin($params){
        if($arrLer = $this->AcoesModel->ler($params)){

            if (empty($arrLer['carros'][0])){
                return false;
            }
            $arrCompare = $arrLer;
            if(count($arrLer['carros']) > 1){
                $countDiff = 0;
                if (!array_diff_key($arrLer['carros'][0], $arrLer['carros'][1])){
                    if (!array_diff($arrLer['carros'][0], $arrLer['carros'][1])){
                        unset($arrCompare);
                        $arrCompare['carros'][0] = $arrLer['carros'][0];
                        unset($arrLer);
                    }
                }
            }

            $countDiff = 0;
            foreach($params as $key => $value){
                if ($arrCompare['carros'][0][$key] != $params[$key]){
                    $countDiff++;
                }
            }
            if($countDiff == 0){
                return $arrCompare['carros'][0];
            }
            return false;
        }
        return false;
    }

    private function criarToken(){
        $caracter = '1234567890abcdefghijklmnopqrstuvwxyz';
        $len = strlen($caracter);
        $token = "";
        for ($n = 1; $n <= 20; $n++){
            $rand = mt_rand(1, $len);
            $token .= $caracter[$rand-1];
        }
        return $token;
    }

    public function login(){
        $metodo = $_SERVER['REQUEST_METHOD'];
        $respStatus = 400;
        $resp = erroPadrao();
        if($metodo != 'POST'){
            $resp = erroRequisicao();
        }
        else{

            $autenticacaoCliente = $this->AutenticacaoModel->autenticacaoCliente();
            if($autenticacaoCliente == true){
                
                $params = json_decode(file_get_contents('php://input'), TRUE);
                
                if ($params['user'] == "" || $params['password'] == ""){
                    $resp = usuarioSenhaVazio();
                }
                else{
                    if($respRead = $this->verificarLogin($params)){
                        $arrConsult['id'] = $respRead["id"];
                        $respRead['token'] = $this->criarToken();
                        $respRead['last_login'] = pegarDataHoraAtual();
                        $respRead['expired_at'] = somarData(1);
                        if($arrResult = $this->AutenticacaoModel->ler($arrConsult)){
                            if ($this->AutenticacaoModel->alterar($arrConsult['id'], $respRead)){
                                    $respStatus = 200;
                                    $resp = sucesso($respRead['token']);
                                }
                                else{
                                    $resp = erroAlterarCarro();
                                }
                        }
                        else{
                            if ($this->AutenticacaoModel->criar($respRead)){
                                $respStatus = 200;
                                $resp = sucesso($respRead['token']);
                            }
                            else{
                                $resp = erroInserirCarro();
                            }
                        }
                    }
                    else{
                        $resp = erroLogin();
                    }
                }
            }
            else{
                $resp = naoAutorizado();
            }
        }
        json_output($respStatus,$resp);
    }

    public function logout(){
        $metodo = $_SERVER['REQUEST_METHOD'];
        $respStatus = 400;
        $resp = erroPadrao();
        if($metodo != 'POST'){
            $resp = erroRequisicao();
        }
        else{
            $autenticacaoCliente = $this->AutenticacaoModel->autenticacaoCliente();
            if($autenticacaoCliente== true){
                $token = $this->input->get_request_header('Authorization', TRUE);
                if ($arrResult = $this->AutenticacaoModel->verificarToken($token)){
                    $idUsuario = $arrResult['idUser'];
                    if($this->AutenticacaoModel->deletar($idUsuario)){
                        $respStatus = 200;
                        $resp = sucesso();
                    }
                    else{
                        $resp = erroLogout();
                    }
                }
                else{
                    $resp = tokenInvalido();
                }
            }
            else{
                $resp = naoAutorizado();
            }
        }
        json_output($respStatus,$resp);
    }
}
