<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'model', 'year'
    ];

    public function brand()
    {
        return $this->belongsTo('App\CarBrand');
    }
}
