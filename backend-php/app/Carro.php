<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    //
    protected $table = "carro";


    protected $fillable = [
        'ano',
        'modelo',
        'marca_id',
    ];


    public function marca()
    {
        return $this->belongsTo('App\Marca','marca_id');
    }


}
