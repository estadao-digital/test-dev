<?php

namespace App\Modules\Brands\Services;

use App\Modules\Brands\Infra\Pixie\Repositories\BrandsRepository;
use App\Modules\Brands\Infra\Pixie\Entities\Brand;
use Exception;

final class CreateBrandService
{
  protected $brandsRepository;

  public function __construct()
  {
    $this->brandsRepository = new BrandsRepository();
  }

  public function execute(array $data): Brand
  {
    $name = $data['name'];

    $findBrand = $this->brandsRepository->findByName($name);

    if ($findBrand) {
      throw new Exception(
        sprintf('The name \'%s\' is already exist.', $name),
        400
      );
    }

    $brand = $this->brandsRepository->create($data);

    return $brand;
  }
}
