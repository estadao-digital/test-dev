<?php

namespace App\Modules\Cars\Services;

use App\Modules\Cars\Infra\Pixie\Repositories\CarsRepository;

final class ListCarsService
{
	protected $carsRepository;

	public function __construct()
	{
		$this->carsRepository = new CarsRepository();
	}

	public function execute(): array
	{
		return $this->carsRepository->all();
	}
}
