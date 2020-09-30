<?php

namespace App\Modules\Cars\Services;

use App\Modules\Brands\Infra\Pixie\Repositories\BrandsRepository;
use App\Modules\Cars\Infra\Pixie\Repositories\CarsRepository;
use App\Modules\Brands\Infra\Pixie\Entities\Brand;
use App\Modules\Cars\Infra\Pixie\Entities\Car;
use Exception;

final class CreateCarService
{
	protected $brandsRepository;

	protected $carsRepository;

	public function __construct()
	{
		$this->brandsRepository = new BrandsRepository();

		$this->carsRepository = new CarsRepository();
	}

	public function execute(array $data): Car
	{
		$brand_id = $data['brand_id'];

		$findBrand = $this->brandsRepository->findById($brand_id);

		if (!$findBrand) {
			throw new Exception(
				sprintf('The brand id \'%s\' does not exist.', $brand_id),
				400
			);
		}

		$model = $data['model'];

		$findCar = $this->carsRepository->findByModel($model);

		if ($findCar) {
			throw new Exception(
				sprintf('The model \'%s\' is already exist.', $model),
				400
			);
		}

		$car = $this->carsRepository->create($data);

		return $car;
	}
}
