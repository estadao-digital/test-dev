<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'brand_id' => 'integer',
        'model_id' => 'integer',
    ];

    protected $fillable = [
        'brand_id',
        'model_id',
        'year'
    ];

    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }

    public function model(){
        return $this->belongsTo('App\Models\Model');
    }
}
