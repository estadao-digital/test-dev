<?php

namespace App\Http\Controllers;

use App\Models\Carros;
use App\Models\JsonService;

class CarrosController extends Controller
{
    public function __construct()
    {
    }
    public function index(){
        return collect(JsonService::load());
    }
    public function load($id){
        $carro = new Carros($id);
        return json_encode($carro);
    }
    public function create(){
        $input = request()->all();
        $carro = (object) $input;
        JsonService::insert($carro);
    }
    public function update($id){
        $input = request()->except('id');
        JsonService::change($id, $input);
        return json_encode(JsonService::get($id), JSON_PRETTY_PRINT);
    }
    public function delete($id){
        return JsonService::delete($id);
    }
}
