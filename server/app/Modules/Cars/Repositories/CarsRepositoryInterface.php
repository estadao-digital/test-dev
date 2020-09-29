<?php

namespace App\Modules\Cars\Repositories;

use App\Modules\Cars\Infra\Pixie\Entities\Car;

interface CarsRepositoryInterface
{
  function all(): array;

  function findById(int $id): ?Car;

  function findByModel(string $model): ?Car;

  function create(array $data): Car;

  function update(array $data, int $id): Car;

  function delete(int $id): void;
}
