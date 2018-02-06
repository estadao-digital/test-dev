<?php

namespace App;

use Illuminate\Http\Request;

use App\Marca;

class Carro
{
    public $id;
    public $marca;
    public $modelo;
    public $ano;

    const PATH_FILE_JSON = "/../database/seeds/data/carros.json";


    public static function all() 
    {
        $json = json_decode(static::load_json(), true);
        return $json;
    } 

    public static function find($id) 
    {
        $carros = static::all();
        $index = array_search($id, array_column($carros, 'id'));

        if($index===false) {
            return array("erro"=>"Carro id não encontrado!");
        }

        return $carros[$index];
    } 

    public static function exists_by_id($id) 
    {
        $carros = static::all();
        $index = array_search($id, array_column($carros, 'id'));

        return $index;
    }

    public static function create($request)
    {
        $marca = $request->input("marca");
        $modelo = $request->input("modelo");
        $ano = $request->input("ano");

        if($marca=="" || Marca::find_index_by_name($marca)===false) {
            return array("erro"=>"Carro não cadastrado, marca não encontrada!");   
        }

        if($modelo=="") {
            return array("erro"=>"Carro não cadastrado, modelo vazio!");   
        }

        if($ano=="") {
            return array("erro"=>"Carro não cadastrado, ano vazio!");   
        }

        $next_id = static::last_id() + 1;
        
        $car_new = array("id"=>$next_id, "marca"=>$marca, "modelo"=>$modelo, "ano"=>$ano);

        $carros = static::all();
        $len = count($carros);
        $carros[$len] = $car_new;

        static::update_cars($carros);

        return $car_new;
    }

    public static function update($request, $id)
    {
        $marca = $request->input("marca");
        $modelo = $request->input("modelo");
        $ano = $request->input("ano");
        $index = static::exists_by_id($id);


        if($id=="" || $index===false) {
            return array("erro"=>"Carro id não cadastrado!");   
        }

        if($marca=="" || Marca::find_index_by_name($marca)===false) {
            return array("erro"=>"Carro não cadastrado, marca não encontrada!");   
        }

        if($modelo=="") {
            return array("erro"=>"Carro não cadastrado, modelo vazio!");   
        }

        if($ano=="") {
            return array("erro"=>"Carro não cadastrado, ano vazio!");   
        }
        
        $car_new = array("id"=>$id, "marca"=>$marca, "modelo"=>$modelo, "ano"=>$ano);

        $carros = static::all();
        $carros[$index] = $car_new;

        static::update_cars($carros);

        return $car_new;
    }

    public static function delete($id)
    {
        $index = static::exists_by_id($id);

        if($id=="" || $index===false) {
            return array("erro"=>"Carro id não cadastrado!");   
        }

        $carros = static::all();

        unset($carros[$index]);
        
        static::update_cars($carros);

        return array('success' => "Carro id:".$id." deletado com sucessso!");;
    }

    protected static function update_cars($cars)
    {
        $file_path = realpath(__DIR__ . static::PATH_FILE_JSON);

        $newCars = [];
        foreach($cars as $c) {
            $newCars[] = $c;
        } 

        file_put_contents($file_path, json_encode($newCars));
    }

    protected static function last_id() 
    {
        $carros = static::all();
        $last_index = count($carros)-1;
        return $carros[$last_index]["id"];
    } 

    protected static function load_json() 
    {
        $file_path = realpath(__DIR__ . static::PATH_FILE_JSON);
        return file_get_contents($file_path);
    } 
}