<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'manufacturer_id', 'model', 'year',
    ];

    public function manufacturer(){
        return $this->belongsTo('App\Model\Manufacturer');
    }
}
