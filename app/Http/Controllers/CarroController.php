<?php

namespace App\Http\Controllers;

use App\Carro;
use App\Marca;
use App\Http\Resources\CarroResource; 
use App\Http\Resources\CarrosResource;
use App\Http\Requests\CarroRequest;
use Validator;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO ARRUMAR ISSO AQUI
        $carros = Carro::all();

        foreach ($carros as &$carro) {
            $carro['marca'] = $carro->marca->marca;
        }
        return new CarrosResource($carros);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //CarroRequest $request)
    {
        // TODO NÃO ADICIONAR CARRO COM MESMO NOME !!!
        
        // $validator = Validator::make($request->all(), [
        //     'modelo' => 'required|max:50',
        //     'marca_id' => 'required',
        //     'ano' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     //$message = $validator->errors();
        //     //$this->SetStatusCode(404);
        //     return "cagou!"; //$message;
        // }
        
        $carro = new Carro();
        $carro->modelo = $request->modelo;
        $carro->marca_id = $this->getMarcaId($request->marca);
        $carro->ano = $request->ano;
        $carro->save();

        // $novoCarro = Carro::create([
        //     'modelo' => Request::get('modelo'),
        //     'marca_id' => Request::get('marca_id'),
        //     'ano' => Request::get('ano')
        // ]);
        // return "Tudo certo na Bahia!";

        // if ($valicacao->fails()) {
        //     return "deu merda!"; //$validator->errors();
        // } else {
        //     $novoCarro = Carro::create([
        //         'modelo' => Request::get('modelo'),
        //         'marca_id' => Request::get('marca_id'),
        //         'ano' => Request::get('ano')
        //     ]);
        //     return "Tudo certo na Bahia!";
        // }
    }

    public function getMarcaId($marca){

        $marca = Marca::firstOrCreate(['marca' => $marca]);
        return $marca->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show(Carro $carro)
    {
        return new CarroResource($carro);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carro $carro)
    {
        // RESOLVER AS PARADAS DA MARCA AQUI !

        $carro->modelo = $request->modelo;
        $carro->marca_id = $this->getMarcaId($request->marca);
        $carro->ano = $request->ano;
        $foi = $carro->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carro $carro)
    {
        $carro->delete();
    }
}
