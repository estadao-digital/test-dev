<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Marca;

class MarcaController extends Controller
{
    public function list()
    {
        $marcas = Marca::all();
        return view('marcas');
    }

    public function index(){
        $marcas = Marca::all();
        return $marcas->toJson();

    }

    public function store(Request $request)
    {
        $marca = new Marca();
        $marca->marca = $request->input('marca');
        $marca->save();
        return json_encode($marca);
    }

    public function show($id)
    {
        $marca = Marca::find($id);
        if (isset($marca)) {
            return json_encode($marca);            
        }
        return response('Marca não encontrada', 404);
    }


    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        if (isset($marca)) {
            $marca->marca = $request->input('marca');
            $marca->save();
            return json_encode($marca);
        }
        return response('Marca não encontrada', 404);
    }
    

    public function destroy($id)
    {
        $marca = Marca::find($id);
        if (isset($marca)) {
            $marca->delete();
            return response('OK', 200);
        }
        return response('Marca não encontrada', 404);
    }
}
