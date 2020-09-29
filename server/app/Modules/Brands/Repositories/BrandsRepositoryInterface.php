<?php

namespace App\Modules\Brands\Repositories;

use App\Modules\Brands\Infra\Pixie\Entities\Brand;

interface BrandsRepositoryInterface
{
  function all(): array;

  function findById(int $id): ?Brand;

  function findByName(string $name): ?Brand;

  function create(array $data): Brand;
}
