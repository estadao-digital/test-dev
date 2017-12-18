<?php

namespace Cars\Car\Entities;

use \Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    protected $fillable = [
                            'name',
                            'model',
                            'image_location',
                            'year',
                            'excluded',
                            'manufacturer_id',
                          ];
}