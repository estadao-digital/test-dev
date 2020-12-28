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

  public static function edit(int $id, $data)
  {
    $ids = array_column(self::$DATA, 'id');
    $cursor = array_search($id, $ids);

    self::$DATA[$cursor] = array_merge(
      (array) self::$DATA[$cursor],
      (array) $data
    );

    self::save();

    return self::$DATA[$cursor];
  }

  public static function remove(int $id)
  {
    $ids = array_column(self::$DATA, 'id');
    $cursor = array_search($id, $ids);

    unset(self::$DATA[$cursor]);

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
