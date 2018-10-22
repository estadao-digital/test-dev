<?php

namespace App;

use App\Traits\CarRelationship;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use CarRelationship;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'model',
        'year'
    ];
}
