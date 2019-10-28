<?php

namespace App\Http\Controllers;

use App\Carro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $carros = Carro::all();
        //echo($carros);
        //dd($carros);

        return response()->json($carros);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $ano = $data["ano"];

        $carro = Carro::create([
            "marca" => $marca,
            "modelo" => $modelo,
            "ano" => $ano
        ]);

        return response()->json($carro);
    }

    /**
     * Display the specified resource.
     *
     * @param Carro $carro
     * @return Response
     */
    public function show(Carro $carro)
    {
        return response()->json($carro);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Carro $carro
     * @return Response
     */
    public function update(Request $request, Carro $carro)
    {

        //dd($carro);

        if ($request->has('marcaEdt')){
            $carro->marca = $request->marcaEdt;
        }

        if ($request->has('modeloEdt')){
            $carro->modelo = $request->modeloEdt;
        }

        if ($request->has('anoEdt')){
            $carro->ano = $request->anoEdt;
        }

        if (!$carro->isDirty()){
            return response()->json('Necessário informar valores diferentes para atualizar');
        }

        $carro->save();

        return response()->json($carro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Carro $carro
     * @return Response
     * @throws Exception
     */
    public function destroy(Carro $carro)
    {
        $carro->delete();
        return response()->json($carro);
    }
}
