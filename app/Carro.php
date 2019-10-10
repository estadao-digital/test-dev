<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    // -- configuração da tabela do banco referente a este model
    protected $table = "carros";

    // -- configuração dos campos permitidos para inclusão/edição
    protected $fillable = [
        "marca", "modelo", "ano", "placa", "cambio", "custo", "venda"
    ];

    // -- regras definidas para cadastrar/editar um carro
    static function rules() {
        return [
            "marca" => 'required', 
            "modelo" => 'required', 
            "ano" => 'required', 
            "placa" => 'required', 
            "cambio" => 'required', 
            "custo" => 'required', 
            "venda" => 'required'
        ];
    }
}
