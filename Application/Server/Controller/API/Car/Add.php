<?php

namespace Application\Server\Controller\API\Car
{
    use Application\Server\Component;
    use Application\Server\Model;

    class Add extends \Controller
    {
        protected static function onInput($type) { return [
            'brandId'   => int,
            'model'     => string,
            'year'      => int
        ]; }

        public static function onRequest($input)
        {
            // Check method
            if (\Connection::getRequestMethod() !== 'post')
                return self::error('INVALID_METHOD', ['message' => 'Only POST method available.']);

            $input = $input->post;

            // Validate inputs
            if (Component\Fipe::getByBrandId($input->brandId) === null)
                return self::error('INVALID_BRAND_ID');

            $currentYear = \DateTimeEx::now()->getYear();
            if (($input->year + 100) < $currentYear || ($input->year - 2) > $currentYear)
                return self::error('INVALID_YEAR');

            if ($input->model->isEmpty() === true)
                return self::error('INVALID_MODEL');

            // Add
            $car = new Model\Car();
            $car->brandId   = $input->brandId;
            $car->model     = $input->model;
            $car->year      = $input->year;
            $car->save();

            // Return
            $data = Arr(['car' => $car->toArr()]);
            $data->car->brand = Component\Fipe::getByBrandId($car->brandId);

            return self::success($data);
        }
    }
}