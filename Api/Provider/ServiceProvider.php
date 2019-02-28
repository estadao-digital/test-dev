<?php

namespace Api\Provider;

use Api\Service\CarService;
use Api\Provider\InterfaceProvider;

class ServiceProvider implements InterfaceProvider
{
    public function register(array $container): array
    {
        $container['car.service'] = new CarService(
            $container['car.repository'],
            $container['brand.repository']
        );

        return $container;
    }
}