<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseModel extends CI_Model{

    var $key_database = "teste123";
    var $file = array();
    var $dir_file = "arquivos/";
    
    public function __construct(){
        parent::__construct();
        $this->file['carro'] = "carro.txt";
        $this->file['auth'] = "users_authentication.txt";
        $this->file['error'] = "error.txt";
        $this->load->helper('data');
    }

    public function criar($file = '', $arrDataFile = array()){
        
        if(($file != 'carro' AND $file != 'auth') OR count($arrDataFile) < 1){
            return false;
        }
        
        if (!$json_str = $this->lerArquivo($file)){
            return false;
        }
        if (count($json_str['carros']) > 0){
            $arrReturn['carros'] = array();
            foreach ($json_str['carros'] as $values){
                foreach ($values as $key => $value){
                    foreach($arrDataFile as $key_comp => $value_comp){
                        if ($key_comp == $key AND $value == $value_comp){
                            $arrReturn['carros'][] = $values;
                        }
                    }
                }
            }
            
            if (count($arrReturn['carros']) > 0){
                return false;
            }
        }
        
        $json_str['carros'][] = $arrDataFile;
        
        if($this->salvarArquivo($file, $json_str)){
            return true;
        } 
        else{
            return false;
        }
    }

    public function alterar($file = '', $id, $arrDataFile = array()){
        
        if(($file != 'carro' AND $file != 'auth') OR ($id == '') OR count($arrDataFile) < 1){
            return false;
        }
        
        if (!$json_str = $this->lerArquivo($file)){
            return false;
        }
        
        $arrReturn = $json_str;
        
        if (count($arrDataFile) > 0){
            foreach ($json_str['carros'] as $keys => $values){
                if($values['id'] == $id){
                    foreach ($values as $key => $value){
                        $keyChange = 0;
                        foreach($arrDataFile as $key_comp => $value_comp){
                            if ($key_comp == $key){
                                $arrReturn['carros'][$keys][$key] = $value_comp;
                                $keyChange = 1;
                            }
                        }
                        if($keyChange == 1){
                            $arrReturn['carros'][$keys]['updated_at'] = pegarDataHoraAtual();
                        }
                    }
                }
            }
        }
                
        if($this->salvarArquivo($file, $arrReturn)){
            return true;
        } 
        else{
            return false;
        }
    }

    public function deletar($file = '', $id){
        
        if(($file != 'carro' AND $file != 'auth') OR ($id == '')){
            return false;
        }
        
        if (!$json_str = $this->lerArquivo($file)){
            return false;
        }
        
        if (count($json_str['carros']) > 0){
            foreach ($json_str['carros'] as $keys => $values){
                if($values['id'] != $id){
                    $arrNew['carros'][$keys] = $values;
                }
            }
        }
        
        if($this->salvarArquivo($file, $arrNew)){
            return true;
        } 
        else{
            return false;
        }
    }

    public function ler($file = '', $arrDataFile = array()){
        if($file != 'carro' AND $file != 'auth'){
            return false;
        }
        
        if (!$jsonArr = $this->lerArquivo($file)){
            return false;
        }
        if (count($arrDataFile) > 0){
            $arrReturn['carros'] = array();
            foreach ($jsonArr['carros'] as $values){
                foreach ($values as $key => $value){
                    if(!empty($arrDataFile[$key]) AND $value==$arrDataFile[$key]){
                        $arrReturn['carros'][] = $values;
                    }
                }
            }
        }
        else{
            $arrReturn = $jsonArr;
        }
        
        return $arrReturn;
    }
    
    private function salvarArquivo($file = 'error', $content = ''){
        
        if(empty($content)){
            return false;
        }
        
        $dataFile = $this->codificar($content);
        
        if (file_put_contents($this->dir_file.$this->file[$file], $dataFile)){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function lerArquivo($file = ''){
        
        if($file != 'carro' AND $file != 'auth'){
            return false;
        }
        $dataFile['carros'] = array();
        if(!file_exists($this->dir_file.$this->file[$file])){
            if (!$this->salvarArquivo($file, $dataFile)){
                return false;
            }
        }
        
        if ($fileContent = file_get_contents($this->dir_file.$this->file[$file])){

            $arrDataReturn = $this->decodificar($fileContent);
            if ($arrDataReturn == $dataFile){
                return $dataFile;
            }
            return $arrDataReturn;
        }
        else{
            return false;
        }
    }
    
    private function codificar($arrDados){
        
        $this->load->library('encrypt');
        
        if (empty($arrDados)){
            return false;
        }
        $json = json_encode($arrDados); 
        $encrypted = $this->encrypt->encode($json, $this->key_database);
        $encrypted = strtr($encrypted,array('+' => '.', '=' => '-', '/' => '~'));
        return $encrypted;
    }

    private function decodificar($encrypted){
        $this->load->library('encrypt');
        
        if (empty($encrypted)){
            return false;
        }
        $arrData = strtr($encrypted,array('.' => '+', '-' => '=', '~' => '/'));
        $decrypted = $this->encrypt->decode($arrData, $this->key_database);
        
        if ($arrJson = json_decode($decrypted, TRUE)){
            return $arrJson;
        }
        else{
            return false;
        }
    }
}

