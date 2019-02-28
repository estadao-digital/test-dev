<?php

namespace Api\Provider;

use Api\Repository\CarRepository;
use Api\Repository\BrandRepository;
use Api\Provider\InterfaceProvider;

class RepositoryProvider implements InterfaceProvider
{
    public function register(array $container): array
    {
        $container['car.repository'] = new CarRepository();
        $container['brand.repository'] = new BrandRepository();

        return $container;
    }
}