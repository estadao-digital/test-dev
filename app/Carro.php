<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $fillable = ['marca_id', 'modelo', 'ano'];
    //Definindo qual tabela irei usar
    protected $table = "carros";
    // definindo que não tem campo created_At updated_at na minha tabela
    public $timestamps = false;

    //definindo o relacionamento de 1 Carro tem 1 Marca
    public function marca()
    {
        return $this->belongsTo('App\Marca');
    }
}