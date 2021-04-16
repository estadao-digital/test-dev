<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{

    protected $fillable = [
        'modelo',
        'marca_id',
        'ano',
        'descricao'
    ];
}
