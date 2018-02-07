<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Carro;
use App\Marca;

class CarroController extends Controller
{
    protected $carro = null;
    public function __construct(Carro $carro){
        $this->carro = $carro;
    }

    public function index()
    {
      $carros = Carro::all();
      $marcas = Marca::all();

      if($carros){
        foreach ($carros as $carro){
          $values[] = array(
            'id'     => $carro->id,
            'modelo' => $carro->modelo,
            'ano'    => $carro->ano,
            'marca'  => Marca::find($carro->marca_id)->descricao ?: '',
            'marca_id'  => $carro->marca_id
          );
        }

        return response()->json(compact('values', 'marcas'), 200);
      } else {
        return response()->json('Nenhum registro encontrado!', 404);
      }
    }

    public function show($id)
    {
      $carro = Carro::find($id);

      if ($carro){
        $values[] = array(
          'id'     => $carro->id,
          'modelo' => $carro->modelo,
          'ano'    => $carro->ano,
          'marca'  => Marca::find($carro->marca_id) ?: '{}'
        );
        return response()->json($values, 200);
      } else {
        return response()->json(['message' => 'Carro não existe!'], 404);
      }
    }

    public function store(Request $request)
    {
      $carro = new Carro();

      // Validação de dados
      $this->validate($request, $this->carro->rules, [],  $this->carro->niceNames);

      $create = $carro->create($request->all());

      if ($create){
        return response()->json([
            'message' => 'Carro cadastrado com sucesso!',
            'carro' => $create
        ], 200);
      } else {
        return response()->json(['message' => 'Ocorreu um erro ao cadastrar!'], 404);
      }

    }

    public function update(Request $request, $id)
    {
      $carro = Carro::find($id);

      if ($carro){
        // Validação de dados
        $this->validate($request, $this->carro->rules, [],  $this->carro->niceNames);

        $carro->update($request->all());

        return response()->json([
            'message' => 'Carro atualizado com sucesso!',
            'carro' => $carro
        ], 200);
      } else {
        return response()->json(['message' => 'Carro não existe!'], 404);
      }

    }

    public function destroy($id)
    {
      $carro = Carro::find($id);

      if ($carro){
        $carro->delete();
        return response()->json([
            'message' => 'Carro excluido com sucesso!',
            'carro' => $carro
        ], 200);
      } else {
        return response()->json(['message' => 'Carro não existe!'], 404);
      }

    }

}
