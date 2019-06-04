<?php

class Carro extends Eloquent
{
  use SoftDeletingTrait;

  protected $table = 'carros';

  protected $fillable = ['marca_id', 'modelo', 'ano'];

  public $timestamps = true;

  public function marca()
  {
    return $this->belongsto('Marca');
  }

  public function setModeloAttribute($value)
  {
    $this->attributes['modelo'] = ucwords(mb_strtolower($value));
  }
}
