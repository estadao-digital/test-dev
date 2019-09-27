<?php

namespace App\Http\Controllers;

use App\Carro;
use App\Http\Requests\CarroRequest;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        return Carro::with('marca')->get()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CarroRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarroRequest $request)
    {
        $r = Carro::create($request->validated());

        return $r;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carro $carro
     * @return string
     */
    public function show(Carro $carro)
    {
        return $carro->load('marca')->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CarroRequest $request
     * @param  \App\Carro  $carro
     * @return bool
     */
    public function update(CarroRequest $request, Carro $carro)
    {
        return json_encode($carro->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carro $carro
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Carro $carro)
    {
        return json_encode($carro->delete());
    }
}
