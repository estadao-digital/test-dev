<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Veiculos;


class VeiculosController extends Controller
{ 
  
    public function index()
    {
        return Veiculos::all();
    }
 
    public function store(Request $request)
    {
        Veiculos::create($request->all());
    }
    
    public function show($id)
    {
        return Veiculos::findOrFail($id);
    }
    
    public function update(Request $request, $id)
    {
        $veiculos = Veiculos::findOrFail($id);
        $veiculos -> update($request ->all());
    }

    public function destroy($id)
    {
        $car = Veiculos::findOrFail($id);
        $car -> delete();
    }
}
