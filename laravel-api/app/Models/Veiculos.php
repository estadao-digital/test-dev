<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculos extends Model
{
    public $timestamps = false; // retirando timestamps

    protected $fillable = [
       'Marca', 'Modelo', 'Ano',
    ];
}

