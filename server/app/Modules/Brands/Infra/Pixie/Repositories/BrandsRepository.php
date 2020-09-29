<?php

namespace App\Modules\Brands\Infra\Pixie\Repositories;

use App\Modules\Brands\Repositories\BrandsRepositoryInterface;
use App\Modules\Brands\Infra\Pixie\Entities\Brand;
use Pixie;

final class BrandsRepository implements BrandsRepositoryInterface
{
  protected $table;

  public function __construct()
  {
    $this->table = 'brands';
  }

  public function all(): array
  {
    $data = Pixie::table($this->table)->get();

    $brands = [];

    foreach($data as $brand) {
      $brands[] = new Brand(
        $brand->id,
        $brand->name
      );
    }

    return $brands;
  }

  public function findById(int $id): ?Brand
  {
    $findBrand = Pixie::table($this->table)->find($id);

    if (!$findBrand) {
      return null;
    }

    $brand = new Brand(
      $findBrand->id,
      $findBrand->name
    );

    return $brand;
  }

  public function findByName(string $name): ?Brand
  {
    $findBrand = Pixie::table($this->table)->find($name, 'name');

    if (!$findBrand) {
      return null;
    }

    $brand = new Brand(
      $findBrand->id,
      $findBrand->name
    );

    return $brand;
  }

  public function create(array $data): Brand
  {
    $brandId = Pixie::table($this->table)->insert($data);

    $createdBrand = Pixie::table($this->table)->find($brandId);

    $brand = new Brand(
      $createdBrand->id,
      $createdBrand->name
    );

    return $brand;
  }
}
