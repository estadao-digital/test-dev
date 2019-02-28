<?php

namespace Api\Controller;

use Api\Input\CarInput;
use Api\Service\CarService;
use Api\Exception\CarNotFoundException;
use Api\Exception\BrandNotFoundException;
use Api\Component\Response\JsonResponse;

class CarController
{
    private $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function getAll()
    {
        $cars = $this->carService->fetchAll();
        $message['data'] = $cars;

        return new JsonResponse($message, 200);
    }

    public function getCar()
    {
        $carId = $_GET['id'] ?? 0;

        try {
            $car = $this->carService->findCar($carId);
            $message['data'] = $car->toArray();
            return new JsonResponse($message, 200);
        } catch(CarNotFoundException $exc) {
            $message['data'] = ['error' => 
                ['id' => 'No cars found with ID equals ' . $carId]
            ];
            return new JsonResponse($message, 400);
        } catch(\Exception $exc) {
            $message['data'] = ['error' => $exc->getMessage()];
            return new JsonResponse($message, 500);
        }
    }

    public function createCar()
    {
        $requestData = json_decode(file_get_contents( 'php://input' ), true);

        try {
            $carInput = new CarInput($requestData);
            $this->carService->createCar($carInput);
            $message['data'] = ['message' => 'Car created with success'];
            
            return new JsonResponse($message, 201);
        } catch(BrandNotFoundException $exc) {
            $message['data'] = ['error' => 
                ['brand' => 'Invalid brand name']
            ];
            return new JsonResponse($message, 400);
        } catch(\Exception $exc) {
            $message['data'] = ['error' => $exc->getMessage()];
            return new JsonResponse($message, 500);
        }
    }

    public function editCar()
    {
        $requestData = json_decode(file_get_contents( 'php://input' ), true);

        $carId = $_GET['id'] ?? 0;

        try {
            $carInput = new CarInput($requestData);
            $this->carService->editCar($carInput, $carId);
            $message['data'] = ['message' => 'Car updated with success'];
            
            return new JsonResponse($message, 200);
        } catch(CarNotFoundException $exc) {
            $message['data'] = ['error' => 
                ['id' => 'No cars found with ID equals ' . $carId]
            ];
            return new JsonResponse($message, 400);
        } catch(BrandNotFoundException $exc) {
            $message['data'] = ['error' => 
                ['brand' => 'Invalid brand name']
            ];
            return new JsonResponse($message, 400);
        } catch(\Exception $exc) {
            $message['data'] = ['error' => $exc->getMessage()];
            return new JsonResponse($message, 500);
        }
    }

    public function deleteCar()
    {
        $carId = $_GET['id'] ?? 0;

        try {
            $this->carService->deleteCar($carId);
            $message['data'] = ['message' => 'Car with  was deleted with success'];
            return new JsonResponse([], 200);
        } catch(CarNotFoundException $exc) {
            $message['data'] = ['error' => 
                ['id' => 'No cars found with ID equals ' . $carId]
            ];
            return new JsonResponse($message, 400);
        } catch(\Exception $exc) {
            $message['data'] = ['error' => $exc->getMessage()];
            return new JsonResponse($message, 500);
        }
    }
}
