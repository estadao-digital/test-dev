<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carro;
use App\Http\Requests\CarroFormRequest;

class CarroController extends Controller
{
    public function index() {
        $carros = Carro::paginate(3);
        return view('carros/index', compact('carros'));
    }
    
    public function create() {
        $marcas = ['chevrolet', 'fiat', 'ford', 'renault', 'volkswagem'];
        return view('carros/create-edit', compact('marcas'));
    }
    
    public function store(CarroFormRequest $request) {
        $carro      = new Carro;
        $dataForm   = $request->all();
        $insert     = $carro->create($dataForm);
 
        if($insert) //Ok ...
            return redirect()->route('carros/index')->with('message', 'Carro inserido com sucesso !');
        else //Ruim ...
            return redirect()->back()->with('error', 'Carro não foi inserido !');
    }
    
    public function edit($id) {
        $carro      = Carro::findOrFail($id);
        $marcas     = ['chevrolet', 'fiat', 'ford', 'renault', 'volkswagem'];
        return view('carros/create-edit', compact('carro', 'marcas'));
    }
      
    public function update(CarroFormRequest $request, $id) {
        $dataForm   = $request->all();        
        $carro      = Carro::findOrFail($id);
        $update     = $carro->update($dataForm);
        
        if($update) {//Ok ...
            return redirect()->route('carros/index')->with('message', 'Carro alterado com sucesso !');
        }else {//Ruim ...
            return redirect()->route('carros/create-edit')->with('errors', 'Falha ao Editar !');
        }
    }
    
    public function show($id) {
        $carro      = Carro::findOrFail($id);
        return view('carros/show', compact('carro'));
    }
    
    public function destroy($id) {
        $carro  = Carro::findOrFail($id);
        $delete = $carro->delete();
        
        if($delete) //Ok ...
            return redirect()->route('carros/index')->with('message', 'Carro excluído com Sucesso !');
        else //Ruim ...
            return redirect()->route('carros/show')->with('errors', 'Falha ao Deletar !');
    }
}
