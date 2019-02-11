<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome'];
    //Definindo o nome da minha tabela
    protected $table = "marcas";
    // falando que não tem campo created_at, updated_at
    public $timestamps = false;

    //definindo o relacionamento de 1 Marca pode ter N Carros
    public function carro()
    {
        $this->hasMany('App\Carro');
    }
}