<?php


namespace App\Repositories;


use App\Model\Car;

class CarRepository extends BaseRepository
{
    public function __construct(Car $car)
    {
        parent::__construct($car);
    }
}
