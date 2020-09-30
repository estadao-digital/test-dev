<?php

namespace App\Modules\Brands\Services;

use App\Modules\Brands\Infra\Pixie\Repositories\BrandsRepository;

final class ListBrandsService
{
	protected $brandsRepository;

	public function __construct()
	{
		$this->brandsRepository = new BrandsRepository();
	}

	public function execute(): array
	{
		return $this->brandsRepository->all();
	}
}
