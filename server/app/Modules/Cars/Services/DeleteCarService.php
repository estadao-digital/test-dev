<?php

namespace App\Modules\Cars\Services;

use App\Modules\Cars\Infra\Pixie\Repositories\CarsRepository;
use Exception;

final class DeleteCarService
{
  protected $carsRepository;

  public function __construct()
  {
    $this->carsRepository = new CarsRepository();
  }

  public function execute(int $id): void
  {
    $findCar = $this->carsRepository->findById($id);

    if (!$findCar) {
      throw new Exception(
        sprintf('The car id \'%s\' does not exist.', $id),
        400
      );
    }

    $this->carsRepository->delete($id);
  }
}
