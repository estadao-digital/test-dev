<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Carro;
use Illuminate\Pagination\Paginator;

class CarroController extends Controller
{
   protected function validarCarro($request)
   {
     $Validator = Validator::make($request->all(),[
       'marca'   => 'required',
       'modelo'     => 'required',
       'ano'      => 'required|numeric|min:0',
     ]);
     return $Validator;
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
          $qtd = $request['qtd'];
          $page = $request['page'];
          Paginator::currentPageResolver(function () use ($page){
            return $page;
          });
          $carros = Carro::paginate($qtd);

          $carros = $carros->appends(Request::capture()->except('page'));

          return response()->json(['carros'=>$carros],200);
        } catch (\Exception $e) {
          return response()->json(['message'=>'Ocorreu um erro no servidor'], 500);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
          //Valida os dados da request
          $validator = $this->validarCarro($request);
          if($validator->fails()){
            return response()->json(['message'=>'Erro',
            'errors'=>$validator->errors()],400);
          }
          $data = $request->only(['marca', 'modelo', 'ano']);
          if ($data) {
            $Carro = Carro::create($data);
            if ($Carro) {
              return response()->json(['data'=>$Carro], 201);
            }else{
              return response()->json(['message'=>'Erro ao criar carro'], 400);
            }
          }else{
            return response()->json(['message'=>'Dados inválidos'], 400);
          }
        } catch (\Exception $e) {
          return response()->json(['message'=>'Ocorreu um erro no servidor'], 500);
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
        try {
          if($id < 0){
            return response()->json(['message'=>'Id menor que zero, por favor, informe um ID válido'], 400);
          }
          $Carro = Carro::find($id);
          if($Carro){
            return response()->json([$Carro], 200);
          }else{
            return response()->json(['message'=>'O veicuo com o '.$id.'não existe'], 404);
          }
        } catch (\Exception $e) {
            return response()->json(['message'=>'Ocorreu um erro no servidor'], 500);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
      try {
        $validator = $this->validarCarro($request);
        if($validator->fails()){
          return response()->json
          (['message'=>'Erro','errors'=>$validator->errors()], 400);
        }
        $data = $request->only(['numero', 'data', 'cvv', 'titular', 'cpf']);
        if($data){
          $Carro = Carro::find($id);
          if($Carro){
            $Carro->update($data);
            return response()->json(['data'=>$Carro], 200);
          }else{
            return response()->json(['message'=>'O carro com id '.$id.' não existe'], 400);
          }
        }else{
          return response()->json(['message'=>'Dados inválidos'], 400);
        }
      } catch (\Exception $e) {
        return response()->json(['message'=>'Ocorreu um erro no servidor'], 500);
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
      try {
        if($id < 0){
          return response()->json(['message'=>'Id menor que zero, por favor, informe um ID válido'], 400);
        }
        $Carro = Carro::find($id);
        if($Carro){
          $Carro->delete();
          return response()->json([], 204);
        }else{
          return response()->json(['message'=>'O carro com o id '.$id.' não existe'], 404);
        }
      } catch (\Exception $e) {
        return response()->json(['message'=>'Ocorreu um erro no servidor'], 500);
      }

    }
}
