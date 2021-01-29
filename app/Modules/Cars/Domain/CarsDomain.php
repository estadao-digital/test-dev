<?php

namespace App\Modules\Cars\Domain;

use App\Modules\Cars\Repository\CarsRepository;
use Illuminate\Database\Eloquent\Model;

class CarsDomain extends Model
{
    public $incrementing = false;

    protected $table = 'cars';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'brand',
        'model',
        'year'
    ];

    /**
     * @param string $id
     * @param string $brand
     * @param string $model
     * @param string $year
     * @return CarsDomain
     */
    public static function _new($id, $brand, $model, $year)
    {
        return new CarsDomain([
            'id'    => $id,
            'brand' => $brand,
            'model' => $model,
            'year'  => $year
        ]);
    }

    /**
     * @param string $id
     * @param string $brand
     * @param string $model
     * @param string $year
     * @return CarsDomain
     */
    public static function _update($id, $brand, $model, $year)
    {
        $car = CarsRepository::_getCarById($id);
        $car->brand = $brand;
        $car->model = $model;
        $car->year  = $year;
        return $car;
    }
}
