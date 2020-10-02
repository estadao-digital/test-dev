<?php

namespace App\Modules\Cars\Services;

use App\Modules\Cars\Infra\Pixie\Repositories\CarsRepository;
use App\Modules\Cars\Infra\Pixie\Entities\Car;
use Exception;

final class UpdateCarService
{
	protected $carsRepository;

	public function __construct()
	{
		$this->carsRepository = new CarsRepository();
	}

	public function execute(array $data, int $id): Car
	{
		$findCar = $this->carsRepository->findById($id);

		if (!$findCar) {
			throw new Exception(
				sprintf('The car id \'%s\' does not exist.', $id),
				400
			);
		}

		$car = $this->carsRepository->update($data, $id);

		return $car;
	}
}
