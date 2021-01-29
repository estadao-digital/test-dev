<?php

namespace App\Modules\Cars\Repository;

use App\Modules\Cars\Domain\CarsDomain;

class CarsRepository
{
    public function _save(CarsDomain $carsDomain)
    {
        return $carsDomain->save();
    }

    public function _destroy($id)
    {
        return CarsDomain::findOrFail($id)->delete();
    }

    public static function _getAllCars()
    {
        return CarsDomain::all();
    }

    public static function _getCarById($id)
    {
        return CarsDomain::findOrFail($id);
    }
}
