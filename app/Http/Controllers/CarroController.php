<?php

namespace App\Http\Controllers;
use App\Carro;
use App\Marca;
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
        return Carro::with('marca')->get();
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carro = new Carro();
        if($carro->create($request->all())){
            return response()->json(['Msg' => 'Sucesso ao Salvar'],200);
        } else{
            return response()->json(['Msg' => 'Falha ao Salvar'], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        return Carro::with('marca')->where('id', $id)->get();
        
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
        $carro = Carro::findOrFail($id);
        
        if($carro->update($request->all())){
            return response()->json(['Msg' => 'Usuario Editado com Sucesso'],200);
        } else{
            return response()->json(['Msg' => 'Falha ao Editar'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carro = Carro::findOrFail($id);
        
        if($carro->delete()){
            return response()->json(['Msg' => 'Usuario Deletado'],200);
        } else{
            return response()->json(['Msg' => 'Erro no Servidor'], 500);
        }
    }
}
