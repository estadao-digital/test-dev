<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
  public $timestamps = false;

  protected $fillable = ['ano', 'marca_id', 'modelo'];

  public $rules = [
        'ano' => 'required|numeric',
        'marca_id' => 'required|numeric',
        'modelo' => 'required',
    ];

    public $niceNames = [
        'ano' => 'Ano',
        'marca_id' => 'Marca',
        'modelo' => 'Modelo',
    ];

    public function marca(){
        return $this->belongsTo(Marca::class);
    }
}
