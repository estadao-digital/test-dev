<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
  public $timestamps = false;

  protected $fillable = ['descricao'];

  public $rules = [
        'descricao' => 'required'
    ];

    public $niceNames = [
        'descricao' => 'Descrição'
    ];

    public function carros(){
        return $this->hasMany(Carro::class);
    }
}
