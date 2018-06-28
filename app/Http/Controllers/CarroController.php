<?php

namespace App\Http\Controllers;

use App\Carro;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public function view(Request $request)
    {
        return view('welcome');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json($request->session()->get('carros', []), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Carro $carro)
    {
        // /carros - [POST] deve cadastrar um novo carro.
        $carros = $request->session()->get('carros', []);

        $carro->id = (count($carros) > 0) ? count($carros)+1 : 0;
        $carro->marca = $request->input('marca');
        $carro->modelo = $request->input('modelo');
        $carro->ano = $request->input('ano');
        array_push($carros, $carro);

        $request->session()->put('carros', $carros);

        return response()->json(['msg' => 'cadastrado com sucesso!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // /carros/{id}[GET] deve retornar o carro com ID especificado.
        $carros = $request->session()->get('carros', []);
        return response()->json($carros[$id], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // /carros/{id}[PUT] deve atualizar os dados do carro com ID especificado.
        $carros = $request->session()->get('carros', []);

        $carros[$id]['marca'] = $request->input('marca');
        $carros[$id]['modelo'] = $request->input('modelo');
        $carros[$id]['ano'] = $request->input('ano');

        $request->session()->put('carros', $carros);
        return response()->json([], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // /carros/{id}[DELETE] deve apagar o carro com ID especificado.
        $carros = $request->session()->get('carros', []);
        unset($carros[$id]);

        $request->session()->put('carros', $carros);
        return response()->json([], 200);
    }
}
