<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{

    protected $fillable = [
        'marca_id',
        'modelo',
        'ano'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function marca(){
        return $this->belongsTo(Marca::class);
    }
}
