<?php

namespace App\Modules\Cars\Infra\Pixie\Entities;

use App\Modules\Brands\Infra\Pixie\Entities\Brand;

final class Car
{
  public $id;

  public $brand_id;

  public $model;

  public $year;

  public function __construct(int $id, int $brand_id, string $model, string $year)
  {
    $this->id = $id;
    $this->brand_id = $brand_id;
    $this->model = $model;
    $this->year = $year;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getBrandId(): int
  {
    return $this->brand_id;
  }

  public function getBrand(): Brand
  {
    return $this->brand;
  }

  public function getModel(): string
  {
    return $this->model;
  }

  public function getYear(): string
  {
    return $this->year;
  }
}
