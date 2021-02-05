<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable =['brand_id','model','year','description','amount','image'];


    public function Brand(){
        return $this->belongsTo(Brand::class);
    }
}
