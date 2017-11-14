<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcasModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'marcas';

    public $timestamps = false;

    protected $fillable = [
        'id', 'nome'
    ];

    public function carros()
    {
        return $this->hasMany('App\Models\CarrosModel');
    }
}