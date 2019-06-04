<?php

class Marca extends Eloquent
{
  protected $table = 'marcas';

  protected $fillable = ['nome'];

  public function carros()
  {
    return $this->hasMany('Carro');
  }
}
