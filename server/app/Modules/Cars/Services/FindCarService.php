<?php

namespace App\Modules\Cars\Services;

use App\Modules\Cars\Infra\Pixie\Repositories\CarsRepository;
use App\Modules\Cars\Infra\Pixie\Entities\Car;
use Exception;

final class FindCarService
{
  protected $carsRepository;

  public function __construct()
  {
    $this->carsRepository = new CarsRepository();
  }

  public function execute(int $id): Car
  {
    $car = $this->carsRepository->findById($id);

    if (!$car) {
      throw new Exception(
        sprintf('The car id \'%s\' does not exist.', $id),
        400
      );
    }

    return $car;
  }
}
