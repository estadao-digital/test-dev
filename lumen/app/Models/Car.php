<?php

namespace App\Models;

class Car
{
    private static $fileBase = '/var/www/lumen/storage/app/cars.json';
    public $id;
    public $brand;
    public $model;
    public $year;

    public function __construct($id = '', $brand = '', $model = '', $year = '')
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public static function all()
    {
        return json_decode(file_get_contents(Car::$fileBase));
    }

    public static function find($id)
    {
        $cars = self::all();

        $result = collect($cars)->filter(function ($car) use ($id) {
            return $car->id == $id;
        })->toArray();

        if (!count($result)) {
            return;
        }

        $car = current($result);

        return new Car(
            $car->id,
            $car->brand,
            $car->model,
            $car->year
        );
    }

    public function save()
    {
        $cars = self::all();
        $car = self::find($this->id);

        if (!$car) {
            $datas = [
                'id' => $this->id,
                'brand' => $this->brand,
                'model' => $this->model,
                'year' => $this->year,
            ];

            $cars[] = $datas;
        } else {
            $cars = collect($cars)->map(function ($item) {
                if ($item->id == $this->id) {
                    $obj = new \stdClass();
                    $obj->id = $this->id;
                    $obj->brand = $this->brand;
                    $obj->model = $this->model;
                    $obj->year = $this->year;

                    return $obj;
                }

                return $item;
            })->toArray();
        }

        $file = fopen(self::$fileBase, 'w');
        fwrite($file, json_encode($cars));
        fclose($file);
    }

    public function delete()
    {
        $cars = self::all();

        $result = collect($cars)->filter(function ($car) {
            return $car->id != $this->id;
        })->toArray();

        $file = fopen(self::$fileBase, 'w');
        fwrite($file, json_encode(array_values($result)));
        fclose($file);
    }
}
