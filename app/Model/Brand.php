<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name'];

    public function car()
    {
        return parent::hasMany(Car::class, 'id_brand', 'id');
    }
}
