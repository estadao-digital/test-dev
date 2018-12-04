<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
  public function registrar(Request $request){
    $dados = $request->all();
    if(!User::where('email', $dados['email'])->count()){
      $dados['password'] = bcrypt($dados['password']);
      $user = User::create($dados);
      return response()->json(['data'=>$user], 201);
    }else{
      return response()->json(['message'=> 'Este e-mail já esta cadastrado.'], 400);
    }
  }
}
