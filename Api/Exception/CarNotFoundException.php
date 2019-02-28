<?php

namespace Api\Exception;

class CarNotFoundException extends \Exception
{
    public function __construct(string $carId)
    {
        parent::__construct(
            "CarNotFoundException: The car with id equals $carId is not exists."
        );
    }
}