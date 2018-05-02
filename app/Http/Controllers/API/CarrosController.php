<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Carros;
use App\Marcas;
use Response;
use Validator;

class CarrosController extends Controller{

  //exibindo consulta na view
  public static function getCarrosView(){
    $carros = Carros::all();
    return view ("welcome")->with("car", $carros);
  }
  public static function getCarroView(Request $request, $id){
    $car = Carros::find($id);
    $marcas = Marcas::all();
    return view ("especific", compact('car', 'marcas'));
  }
  public static function getMarcasView(){
    $marcas = Marcas::all();
    return view ("register")->with("marcas", $marcas);
  }
  //API com retorno JSON
  public static function getMarcas(){
    $marcas = Marcas::all();
    return response()->json($marcas);
  }
  public static function getCarros(){
    $carros = Carros::all();
    return response()->json($carros);
  }
  public function getCarro(Request $request, $id) {
    $carro = Carros::where('id', $id)->get();
    return response()->json($carro, 200);
  }
  public function deleteCarro(Request $request, $id){
    $delete = Carros::find($id);
    $delete -> delete();
    return response()->json(['success'=>'Carro excluído com sucesso!']);
  }
  public function insertCarro(Request $request){
    $validator = Validator::make($request->all(), [
      'marca' => 'required',
      'modelo' => 'required',
      'ano' => 'required |min:4 | max:4',
    ]);
    if ($validator->fails()) {
      return response()->json(['success'=>'Todos os campos devem ser preenchidos']);
    }else{
      $newCarro = new Carros;
      $newCarro->timestamps = false;
      $newCarro->marca = $request->marca;
      $newCarro->modelo = $request->modelo;
      $newCarro->ano = $request->ano;
      $newCarro->save();
      return response()->json(['success'=>'Cadastro efetuado com sucesso!']);
    }
  }
  public function updateCarro(Request $request, $id){
    $validator = Validator::make($request->all(), [
      'marca' => 'required',
      'modelo' => 'required',
      'ano' => 'required |min:4 | max:4',
    ]);
    if ($validator->fails()) {
      return response()->json(['success'=>'Todos os campos devem ser preenchidos']);
    }else{
      $update_carro = Carros::find($id);
      $update_carro->timestamps = false;
      $update_carro->marca = $request->marca;
      $update_carro->modelo = $request->modelo;
      $update_carro->ano = $request->ano;
      $update_carro->save();
      return response()->json(['success'=>'Atualizado com sucesso!']);
    }

  }

}

?>
