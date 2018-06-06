<?php

namespace App\Http\Controllers;

use App\Carro;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        $carros = Carro::all();
        return view('carro.index',compact('carros', $carros));
     }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carro.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
         //Validate
         $request->validate([
             'marca' => 'required',
             'modelo' => 'required',
             'ano' => 'required',
             'preco' => 'required',
         ]);

         $carro = Carro::create(['marca' => $request->marca,'modelo' => $request->modelo,'ano' => $request->ano,'preco' => $request->preco]);
         $request->session()->flash('message', 'Informações incluídas com sucesso!');
         return redirect('/carro');
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show(Carro $carro)
    {
        return view('carro.show',compact('carro', $carro));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        return view('carro.edit',compact('carro', $carro));
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
      //Validate
      $request->validate([
        'marca' => 'required',
        'modelo' => 'required',
        'ano' => 'required',
        'preco' => 'required|integer',
      ]);

      $carro->marca = $request->marca;
      $carro->modelo = $request->modelo;
      $carro->ano = $request->ano;
      $carro->preco = $request->preco;
      $carro->save();
      $request->session()->flash('message', 'Informações alteradas com sucesso!');
      return redirect('carro');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Carro $carro)
    {
      $carro->delete();
      $request->session()->flash('message', 'Informações deletadas com sucesso!');
      return redirect('carro');
    }
}
