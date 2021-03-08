<?php

namespace Application\Server\Controller\API\Car
{
    use Application\Server\Model;
    use Application\Server\Component;

    class GetAll extends \Controller
    {
        public static function onRequest($input)
        {
            // Check method
            if (\Connection::getRequestMethod() !== 'get')
                return self::error('INVALID_METHOD', ['message' => 'Only GET method available.']);

            // Return
            $cars = Model\Car::getAll();
            $cars = (($cars === null) ? Arr() : $cars->toArr(true));

            $brands = Component\Fipe::getBrands();
            foreach ($cars as $car)
                $car->brand = $brands[$car->brandId];

            return self::success(['cars' => $cars]);
        }
    }
}