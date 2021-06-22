<?php
/**
* Classe do carro
*/
class Carro {
    private $id;
    private $marca;
    private $modelo;
    private $ano;

    //===============================================
    public function __construct($id = null, $marca = null, $modelo = null, $ano = null){
        $this->$id = $id;
        $this->$marca = $marca;
        $this->$modelo = $modelo;
        $this->$ano = $ano;
    }

    //===============================================
    public function getAllCarros(){
        //Api
        $api = new Api();
        $response = $api->apiCon('GET', 'carros');
        //Retornar
        return $response;
    }

    //===============================================
    public function getCarro($id){
        //Api
        $api = new Api();
        $response = $api->apiCon('GET', 'carros', $id);
        //Retornar
        return $response;
    }

    public function getMarcas(){
        //Api
        $api = new Api();
        $response = $api->apiCon('GET', 'marcas');
        //Retornar
        return $response;
    }
}

/**
* Classe API
*/
class Api {

    //===============================================
    public function __construct(){}

    //===============================================
    public function apiCon($method, $loc, $id = ''){
        //===============================================
        $curl = curl_init();
        //===============================================
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost:8080/'.$loc.'/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_PROXY => $_SERVER['SERVER_ADDR'] . ':' .  $_SERVER['SERVER_PORT'],
        CURLOPT_HTTPHEADER => array(
                'Cookie: XDEBUG_SESSION=PHPSTORM'
            ),
        ));
        //===============================================
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        //===============================================
        if(curl_errno($curl)) { print curl_error($curl); } 
        curl_close($curl); 
        //===============================================
        return $response;
    }
}

