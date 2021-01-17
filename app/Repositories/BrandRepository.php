<?php


namespace App\Repositories;


use App\Model\Brand;

class BrandRepository extends BaseRepository
{
    public function __construct(Brand $brand)
    {
        parent::__construct($brand);
    }
}
