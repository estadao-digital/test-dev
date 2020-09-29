<?php

namespace App\Modules\Cars\Infra\Pixie\Repositories;

use App\Modules\Cars\Repositories\CarsRepositoryInterface;
use App\Modules\Brands\Infra\Pixie\Entities\Brand;
use App\Modules\Cars\Infra\Pixie\Entities\Car;
use Pixie;

final class CarsRepository implements CarsRepositoryInterface
{
  protected $table;

  public function __construct()
  {
    $this->table = 'cars';
  }

  public function all(): array
  {
    $data = Pixie::table($this->table)->get();

    $cars = [];

    foreach($data as $car) {
      $cars[] = new Car(
        $car->id,
        $car->brand_id,
        $car->model,
        $car->year
      );
    }

    return $cars;
  }

  public function findById(int $id): ?Car
  {
    $findCar = Pixie::table($this->table)->find($id);

    if (!$findCar) {
      return null;
    }

    $car = new Car(
      $findCar->id,
      $findCar->brand_id,
      $findCar->model,
      $findCar->year
    );

    return $car;
  }

  public function findByModel(string $model): ?Car
  {
    $findCar = Pixie::table($this->table)->find($model, 'model');

    if (!$findCar) {
      return null;
    }

    $car = new Car(
      $findCar->id,
      $findCar->brand_id,
      $findCar->model,
      $findCar->year
    );

    return $car;
  }

  public function create(array $data): Car
  {
    $carId = Pixie::table($this->table)->insert($data);

    $createdCar = Pixie::table($this->table)->find($carId);

    $car = new Car(
      $createdCar->id,
      $createdCar->brand_id,
      $createdCar->model,
      $createdCar->year
    );

    return $car;
  }

  public function update(array $data, int $id): Car
  {
    Pixie::table($this->table)->where('id', $id)->update($data);

    $updatedCar = Pixie::table($this->table)->find($id);

    $car = new Car(
      $updatedCar->id,
      $updatedCar->brand_id,
      $updatedCar->model,
      $updatedCar->year
    );

    return $car;
  }

  public function delete(int $id): void
  {
    Pixie::table($this->table)->where('id', $id)->delete();
  }
}
