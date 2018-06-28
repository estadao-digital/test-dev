<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $fillable = [
        'id',
        'marca',
        'modelo',
        'ano'
    ];
}
