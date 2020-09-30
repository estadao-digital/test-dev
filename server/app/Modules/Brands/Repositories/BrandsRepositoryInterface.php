<?php

namespace App\Modules\Brands\Repositories;

use App\Modules\Brands\Infra\Pixie\Entities\Brand;

interface BrandsRepositoryInterface
{
	public function all(): array;

	public function findById(int $id): ?Brand;

	public function findByName(string $name): ?Brand;

	public function create(array $data): Brand;
}
