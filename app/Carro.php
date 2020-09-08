<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{

    protected $fillable = [
        'marca_id',
        'modelo',
        'ano',
    ];
    
    protected $table = 'carro';

    public function marca(){
        return $this->belongsTo(Marca::class, 'marca_id','id');
    }
}
