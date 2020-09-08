<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = [
        'nome',
    ];
    
    protected $table = 'marca';

    public function carro(){
        return $this->hasMany(Carro::class);
    }
}
