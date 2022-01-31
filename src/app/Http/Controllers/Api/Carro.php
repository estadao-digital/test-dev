<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Carro as Mod_Carro;
use Validator;

class Carro extends Controller
{
    public function  index($id = 0 ){
        try{
            if($id == 0){
                $carros = Mod_Carro::all();
            }else{
                $carros = Mod_Carro::find($id);
            }

            return  $this->success($carros,"Lista de carros", 200);
        } catch (\Exception  $e) {           
            return $this->error('', 'Erro geral informe o desenvolvedor', 500);
        }
    }

    public function  insert(Request $request){
        try{
            $data = Validator::make($request->all(), [
                'marca' =>'required',
                'modelo' =>'required',
                'combustivel' =>'required',
                'ano' =>'required|numeric',
                'valor' =>'required|numeric'
            ]);

            if ($data->fails()) {
                return $this->error($data->errors()->getMessages(), 'Erro ao inserir carro', 401);
            }

            $carro = Mod_Carro::create(($request->only('marca', 'modelo',  'combustivel', 'ano', 'valor')));

            return $this->success(['carro_id' => $carro->id], "Carro inserido com sucesso!", 201);
        } catch (\Exception  $e) {           
            return $this->error('', 'Erro geral informe o desenvolvedor', 500);
        }
    }

    public function  delete(Request $request){
        try{
            $data = Validator::make($request->all(), [
                'id' =>'required|numeric|exists:carros,id',
            ]);

            if ($data->fails()) {
                return $this->error($data->errors()->getMessages(), 'Erro ao deletar carro', 401);
            }
            
            Mod_Carro::where('id', $request->id)->delete();

            return $this->success(['carro_id' => $request->id], "Carro deletado com sucesso!", 200);
        } catch (\Exception  $e) {           
            return $this->error('', 'Erro geral informe o desenvolvedor', 500);
        }
    }    

    public function  update(Request $request, $id){
        try{
            $carro = Mod_Carro::where('id', $id);
        
            if($carro->count() == 0){
                return $this->error("", 'Erro ao atualizar carro, id carro não existe', 401);
            }

            $data = Validator::make($request->all(), [
                'marca' =>'required',
                'modelo' =>'required',
                'combustivel' =>'required',
                'ano' =>'required|numeric',
                'valor' =>'required|numeric'
            ]);
        
            if ($data->fails()) {
                return $this->error($data->errors()->getMessages(), 'Erro ao atualizar carro', 401);
            }
            
            $carro->update($request->only('marca', 'modelo',  'combustivel', 'ano', 'valor'));

            return $this->success(['carro_id' => $id], "Carro alterado com sucesso!", 200);
        } catch (\Exception  $e) {           
            return $this->error('', 'Erro geral informe o desenvolvedor', 500);
        }
    
    }
}
