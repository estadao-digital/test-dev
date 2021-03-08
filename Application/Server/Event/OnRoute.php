<?php

namespace Application\Server\Event
{
    class OnRoute
    {
        public static function onRoute($route)
        {
            $router = new \Router();

            $router->add('/',                       'Application/Server/Controller/Index');
            $router->add('/car',                    'Application/Server/Controller/Car');

            $router->add('/api/car/brand',          'Application/Server/Controller/API/Fipe/Brand/GetAll');
            $router->add('/api/car/add',            'Application/Server/Controller/API/Car/Add');
            $router->add('/api/car/{{ carId }}',    'Application/Server/Controller/API/Car/UpdateByCarId');
            $router->add('/api/car',                'Application/Server/Controller/API/Car/GetAll');

            return $router;
        }
    }
}