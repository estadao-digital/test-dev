<?php

namespace App\Modules\Cars\Repositories;

use App\Modules\Cars\Infra\Pixie\Entities\Car;

interface CarsRepositoryInterface
{
	public function all(): array;

	public function findById(int $id): ?Car;

	public function findByModel(string $model): ?Car;

	public function create(array $data): Car;

	public function update(array $data, int $id): Car;

	public function delete(int $id): void;
}
