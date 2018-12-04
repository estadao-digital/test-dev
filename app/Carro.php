<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 03/12/18
 * Time: 10:32
 */

namespace App;


use Faker\Provider\Person;
use Illuminate\Support\Facades\Storage;

class Carro
{

    protected $cars = [];
    protected $car = ['marca' => '', 'modelo' => '', 'cor' => '', 'ano' => ''];
    protected $fileName = 'cars.json';
    protected $storage, $resource;

    public function __construct()
    {
        $this->storage = Storage::disk('local');

        if (!$this->storage->exists($this->fileName)) {
            $this->storage->append($this->fileName, json_encode($this->car));
        }
        $this->prepareModel();
    }

    public function all()
    {
        $this->prepareModel();
        return $this->cars;
    }

    public function getById($id)
    {
        if(!isset($this->cars[$id]))
            return false;

        return $this->cars[$id];
    }

    public function create($data)
    {
        $this->fill($data);
        $this->cars = array_values($this->cars);
        array_push($this->cars,$this->car);
        return $this->updateFile();
    }

    public function update($data,$id)
    {
        $this->fill($data);

        if(!isset($this->cars[$id]))
            return false;

        $this->cars[$id]=$this->car;

        return $this->updateFile();
    }

    public function delete($id)
    {
        if(!isset($this->cars[$id]))
            return false;
        unset($this->cars[$id]);

        return $this->updateFile();
    }

    public function setFake()
    {
        $this->car = $this->getFake();
        return $this->updateFile();
    }

    public function getFake()
    {
        $car = $this->car;
        $car['ano']=Person::numberBetween(1980,2018);
        $car['cor']=Person::randomElement(['Azul','Prata','Vermelho','Preto']);
        $car['marca']=Person::randomElement(['GM','Ford','Fiat']);
        $car['modelo']=Person::randomElement(['Popular','Esportivo','Executivo']);

        return $car;
    }

    protected function fill($data)
    {
        $car = $this->car;
        foreach ($data as $key => $value){
            if(isset($car[$key])){
                $car[$key] =$value;
            }
        };
        $this->car = $car;
    }

    protected function updateFile()
    {
        $this->resource = json_encode($this->cars,JSON_PRETTY_PRINT);
        return $this->storage->put($this->fileName,$this->resource);
    }

    protected function prepareModel()
    {
        $this->resource = $this->storage->get($this->fileName);
        if ($this->resource == "")
            $this->resource = "{}";
        $this->cars = json_decode($this->resource,  true);
    }
}