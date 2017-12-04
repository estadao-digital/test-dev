<?php

namespace models;

class Carros extends Model {

    public function SelectAll($offset = 0, $limit = false) {
        $data = array(
            'total' => 0,
            'status' => 0,
            'code' => 500,
            'message' => "Erro ao acessar banco de dados"
        );
        $jsondata = json_decode($this->getDB(), true);
        if (!$jsondata) {
            $data['message'] = $data['message'] . " " . $jsondata;
            return $data;
        }
        $offset = $offset;
        $limit = !$limit ? count($jsondata['carros']) : $limit > count($jsondata['carros']) ? count($jsondata['carros']) : $limit;

        $data = array(
            'total' => count($jsondata['carros']),
            'carros' => '',
            'status' => 1,
            'code' => 200,
            'message' => "Dados Listado com sucesso!",
        );


        for ($i = $offset; $i < $limit; $i++) {
            $data['carros'][] = $jsondata['carros'][$i];
        }
        return $data;
    }

    public function SelectAllById($id = false) {
        $jsondata = json_decode($this->getDB(), true);
        foreach ($jsondata['carros'] as $key => $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return false;
    }

    public function Insert($carro) {
        $data = array(
            'status' => 0,
            'code' => 500,
            'message' => "Erro ao acessar banco de dados"
        );
        $jsondata = json_decode($this->getDB(), true);
        $carro['id'] = count($jsondata['carros']) + 1;
        $jsondata['carros'][] = $carro;
        if ($this->setDB($jsondata)) {
            $data = array(
                'status' => 1,
                'code' => 200,
                'message' => "Carro inserido com sucesso",
                'carro' => $carro
            );
        }

        return $data;
    }

    public function Update($carro) {
        $data = array(
            'status' => 0,
            'code' => 500,
            'message' => "Erro ao acessar banco de dados"
        );
        $jsondata = json_decode($this->getDB(), true);

        foreach ($jsondata['carros'] as $key => $value) {
            if ($value['id'] == $carro['id']) {
                $jsondata['carros'][$key] = $carro;
                if ($this->setDB($jsondata)) {
                    $data = array(
                        'status' => 1,
                        'code' => 200,
                        'message' => "Carro alterado com sucesso",
                        'carro' => $carro
                    );
                    return $data;
                }
            }
        }
        return $data;
    }
    
    public function Delete($id) {
        $data = array(
            'status' => 0,
            'code' => 500,
            'message' => "Erro ao acessar banco de dados"
        );
        $jsondata = json_decode($this->getDB(), true);

        foreach ($jsondata['carros'] as $key => $value) {
            if ($value['id'] == $id ) {
                $carro = $jsondata['carros'][$key];
                unset($jsondata['carros'][$key]);
                
                if ($this->setDB($jsondata)) {
                    $data = array(
                        'status' => 1,
                        'code' => 200,
                        'message' => "Carro removido com sucesso",
                        'carro' => $carro
                    );
                    return $data;
                }
            }
        }
        return $data;
    }

}
