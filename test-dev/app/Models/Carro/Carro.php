<?php

namespace App\Models\Carro;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $fillable = ['id_marca','nome_carro','cor'];
    protected $table = 'carros';
}
