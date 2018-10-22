<?php

namespace App\Traits;

use App\Brand;

/**
 * Class CarRelationship
 *
 * @package App\Traits
 */
trait CarRelationship
{
    public function brand() 
    {
        return $this->belongsTo(Brand::class);
    }
}