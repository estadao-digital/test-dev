<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrosModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carros';

    public $timestamps = false;

    protected $fillable = [
        'id', 'modelo', 'ano', 'id_marca'
    ];

    public function marca()
    {
        return $this->belongsTo('App\Models\MarcasModel', 'id_marca');
    }
}