<?php

namespace App\Models;

class Carro {
    
    private $db;

    public function __construct()
    {
        $this->db = json_decode( file_get_contents(getcwd().'/app/Models/db.json'), true );
    }

    private function getCarsById(Int $id)
    {
        return array_filter($this->db, function ($key) use ($id) {
            return $this->db[$key]['id'] == $id;
        }, ARRAY_FILTER_USE_KEY);
    }

    public function getAllBrands(String $marca)
    {

    }

    public function getCars(Int $id = null)
    {
        return is_null($id) ? $this->db : $this->getCarrosById($id);
    }

    public function saveCar(String $data)
    {
        $last = end($this->db);
        $data = json_decode($data, true);
        //$data['id'] = intval($last['id'], 10) + 1;

        $data = ['id' => intval($last['id'], 10) + 1] + $data;

        array_push($this->db, $data);
        file_put_contents(getcwd().'/app/Models/db.json', json_encode($this->db, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        return $this->getCars();
    }

    public function updateCar($id, String $data)
    {
        $data = json_decode($data, true);
        
        foreach ($this->db as $k => $v) {
            if ($v['id'] == $id) {
                
                $this->db[$k]['marca'] = $data['marca'];
                $this->db[$k]['modelo'] = $data['modelo'];
                $this->db[$k]['ano'] = $data['ano'];
                
                file_put_contents(getcwd().'/app/Models/db.json', json_encode($this->db, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return $this->getCars();
            }
        }

        return ['status' => false];
    }

    public function deleteCar($id)
    {
        foreach ($this->db as $k => $v) {
            if ($v['id'] == $id) {
                unset($this->db[$k]);
                file_put_contents(getcwd().'/app/Models/db.json', json_encode($this->db, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return $this->getCars();
            }
        }

        return ['status' => false];
    }

}