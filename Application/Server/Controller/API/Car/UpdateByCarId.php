<?php

namespace Application\Server\Controller\API\Car
{
    use Application\Server\Component;
    use Application\Server\Model;

    class UpdateByCarId extends \Controller
    {
        protected static function onInput($type) { return [
            'brandId'   => string,
            'model'     => string,
            'year'      => int
        ]; }

        public static function onRequest($input)
        {
            // Check method
            $method = \Connection::getRequestMethod();
            if ($method !== 'post' && $method !== 'get' && $method !== 'delete')
                return self::error('INVALID_METHOD', ['message' => 'Only GET/POST/DELETE method available.']);

            $input = $input->post;

            $car = Model\Car::getByCarId($input->carId);
            if ($car === null || $car->deleted === true)
                return self::error('INVALID_CAR_ID');

            // Alternate methods
            if ($method === 'post')
                return self::onUpdate($input, $car);
            elseif ($method === 'delete')
                return self::onDelete($car);

            $data = Arr(['car' => $car->toArr()]);
            $data->car->brand = Component\Fipe::getByBrandId($car->brandId);

            return self::success($data);
        }

        protected static function onUpdate($input, $car)
        {
            // Validate inputs
            if (Component\Fipe::getByBrandId($input->brandId) === null)
                return self::error('INVALID_BRAND_ID');

            $currentYear = \DateTimeEx::now()->getYear();
            if (($input->year + 100) < $currentYear || ($input->year - 2) > $currentYear)
                return self::error('INVALID_YEAR');

            if ($input->model->isEmpty() === true)
                return self::error('INVALID_MODEL');

            // Update
            $car->brandId   = $input->brandId;
            $car->model     = $input->model;
            $car->year      = $input->year;
            $car->save();

            $data = Arr(['car' => $car->toArr()]);
            $data->car->brand = Component\Fipe::getByBrandId($car->brandId);

            return self::success($data);
        }

        protected static function onDelete($car)
        {
            if ($car->deleted === true)
                return self::error('INVALID_CAR_ID');

            // Update
            $car->deleted = true;
            $car->save();

            return self::success(['car' => $car->toArr()]);
        }
    }
}