<?php

namespace api;

class Makers
{
  private static $DATA = [];

  public static function takeAll()
  {
    return self::$DATA;
  }

  public static function load()
  {
    $TABLE = __DIR__ . '/../../../db/makers.json';
    self::$DATA = json_decode(file_get_contents($TABLE));
  }
}
