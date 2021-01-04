<?php

namespace api;

class Cars
{
  private static $DATA = [];

  public static function takeAll()
  {
    return self::$DATA;
  }

  public static function add($car)
  {
    $car->id = count(self::$DATA) + 1;
    self::$DATA[] = $car;
    self::save();

    return $car;
  }

  public static function edit($car, $data)
  {
    $ids = array_column(self::$DATA, 'id');
    $cursor = array_search($car->id, $ids);

    $updated = array_merge(
      (array) $car,
      (array) $data
    );

    self::$DATA[$cursor] = $updated;

    self::save();

    return $updated;
  }

  public static function remove(int $id)
  {
    $newData = array();

    foreach (self::$DATA as $car) {
      if ($car->id !== $id) {
        array_push($newData, $car);
      }
    }

    self::$DATA = (array) $newData;

    self::save();

    return [];
  }

  public static function takeById(int $id)
  {
    foreach (self::$DATA as $car) {
      if ($car->id === $id) {
        return $car;
      }
    }

    return [];
  }

  public static function load()
  {
    $TABLE = __DIR__ . '/../../../db/cars.json';
    self::$DATA = json_decode(file_get_contents($TABLE));
  }

  public static function save()
  {
    $TABLE = __DIR__ . '/../../../db/cars.json';
    file_put_contents(
      $TABLE,
      json_encode(self::$DATA, JSON_PRETTY_PRINT)
    );
  }
}
