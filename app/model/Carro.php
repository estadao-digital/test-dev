<?php

namespace Model;

class Carro implements \Crud
{
    private $db;

    public function __construct()
    {
        $this->db = new \DataBase();
    }

    public function listar()
    {
        $source = $this->db->getSourceArray();
        return $source;
    }

    public function incluir(array $data)
    {
        $source = $this->db->getSourceArray();
        array_push($source['carros'], $data);
        return file_put_contents($this->db->getFile(), json_encode($source)) == true;
    }

    public function editar($id, array $data)
    {
        $source = $this->db->getSourceArray();
        if(!isset($source['carros'][$id])) {
            throw new \Exception('Carro não existe');
        }
        unset($data['id']);
        $source['carros'][$id] = array_merge($source['carros'][$id], $data);
        return file_put_contents($this->db->getFile(), json_encode($source)) == true;
    }

    public function excluir($id)
    {
        $source = $this->db->getSourceArray();
        if(!isset($source['carros'][$id])) {
            throw new \Exception('Carro não existe');
        }
        unset($source['carros'][$id]);
        return file_put_contents($this->db->getFile(), json_encode($source)) == true;
    }

    public function get($id)
    {
        $source = $this->db->getSourceArray();
        if(!isset($source['carros'][$id])) {
            throw new \Exception('Carro não existe');
        }
        return $source['carros'][$id];
    }
}
