<?php

namespace Api\Routes;

use Api\Routes\AbstractRoutes;
use Api\Controller\CarController;

class CarRoutes extends AbstractRoutes
{
    public function getRoutes(): array
    {
        $controller = new CarController($this->container['car.service']);

        $routes['getAllCars'] = [
            'route' => '/', 
            'controller' => $controller, 
            'action' => 'getAll',
            'method' => 'GET'
        ];

        $routes['getCar'] = [
            'route' => '/find', 
            'controller' => $controller, 
            'action' => 'getCar',
            'method' => 'GET'
        ];

        $routes['createCar'] = [
            'route' => '/', 
            'controller' => $controller, 
            'action' => 'createCar',
            'method' => 'POST'
        ];
        
        $routes['editCar'] = [
            'route' => '/', 
            'controller' => $controller, 
            'action' => 'editCar',
            'method' => 'PUT'
        ];

        $routes['deleteCar'] = [
            'route' => '/', 
            'controller' => $controller, 
            'action' => 'deleteCar',
            'method' => 'DELETE'
        ];

        return $routes;
    }
}
