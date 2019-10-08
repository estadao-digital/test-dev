<?php

namespace App\Http\Controllers;

use App\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class CrudController extends Controller
{
    public function index(){
        $carros = Crud::get();

        return view('cruds.lista', ['cruds' => $carros]);
    }
    public function novo(){
        return view('cruds.formulario');

}
    public function salvar(Request $request){
        $carros = new Crud();
        $carros = $carros->create($request->all());
        \Session::flash('mensagem_sucesso', 'Carro Cadastrado com Sucesso!');
        return Redirect::to('cruds');
    }

    public function editar($id){
        $carros = Crud::findOrfail($id);
        return view('cruds.formulario', ['cruds' => $carros]);

    }

    public function atualizar($id, Request $request) {
        $carros = Crud::findOrfail($id);
        $carros->update($request->all());
        \Session::flash('mensagem_sucesso', 'Carro Atualizado com Sucesso!');
        return Redirect::to('cruds/'.$carros->id.'/editar');
    }
    public function deletar($id){
        $carros = Crud::findOrfail($id);
        $carros->delete();
        \Session::flash('mensagem_sucesso', 'Carro Deletado com Sucesso!');
        return Redirect::to('cruds');
    }
}
