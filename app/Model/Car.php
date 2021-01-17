<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['id_brand', 'model', 'year'];

    public function car_brand()
    {
        return parent::belongsTo(Brand::class, 'id_brand', 'id');
    }
}
