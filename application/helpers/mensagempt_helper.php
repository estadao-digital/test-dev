<?php

function erroPadrao(){
    return array('status' => 400,'message' =>  'Erro Padrao');
}

function erroRequisicao(){
    return array('status' => 400,'message' => 'Erro requisicao');
}

function naoAutorizado(){
    return array('status' => 400,'message' =>  'Nao Autorizado');
}

function dadosIncompletos(){
    return array('status' => 400,'message' =>  'Dados incompletos');
}

function sucessoUsuarioId($id){
    return array('status' => 200,'message' =>  'Sucesso','id' =>  $id);
}

function erroInserirCarro(){
    return array('status' => 400,'message' =>  'Erro ao inserir carro');
}

function erroGerarCarro(){
    return array('status' => 400,'message' =>  'Erro ao gerar carro');
}

function sucesso($token = NULL){
    if($token){
        return array('status' => 200,'message' =>  'Sucesso.','token' =>  $token);
    }
    return array('status' => 200,'message' =>  'Sucesso');
}

function erroAlterarCarro(){
    return array('status' => 400,'message' =>  'Erro ao alterar o carro');
}

function carroInexistente(){
    return array('status' => 400,'message' =>  'Erro carro Inexistente');
}

function erroDeletarCarro(){
    return array('status' => 400,'message' =>  'Erro ao Deletar carro');
}

function usuarioSenhaVazio(){
    return array('status' => 400,'message' =>  'Usuario ou senha vazio');
}

function erroLogin(){
    return array('status' => 400,'message' =>  'Erro Login');
}

function erroLogout(){
    return array('status' => 400,'message' =>  'Erro Logout');
}

function tokenInvalido(){
    return array('status' => 400,'message' =>  'Token invalido');
}

function autorizado(){
    return array('status' => 401,'message' => 'Autorizado');
}

