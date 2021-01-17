<?php


namespace App\Services;


use App\Repositories\BrandRepository;

class BrandService
{
    public $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function checkBrandById(int $idBrand): bool
    {
        $brand = $this->brandRepository->find($idBrand);

        if (is_null($brand) || $brand->count() <= 0) {
            return false;
        }

        return true;
    }

}
