<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    public function marca()
    {
        return $this->belongsTo('App\Marca');    
    }
}
