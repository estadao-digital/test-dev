<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\Eloquent\CarRepository;

class CarService extends Service
{
    /**
     * Default property for car repository.
     *
     * @var $carRepository
     */
    protected $carRepository;

    /**
     * Set default instance for repository.
     *
     * @param CarRepository $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * Get all cars from collection.
     *
     * @return array
     */
    public function getAllCars() : array
    {
        try {
            $entities = $this->carRepository->getAllCars();

            if (0 === count($entities)) {
                throw new \Exception(trans('api.cars_http_status_code_404'));
            }

            return [
                'code' => (int) 200,
                'message' => (string) 'Ok',
                'data' => $entities
            ];
        } catch (\Exception $ex) {
            return [
                'code' => (int) 404,
                'message' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Create a new car into collection.
     *
     * @param array $data
     * @return array
     */
    public function storeNewCar(array $data) : array
    {
        try {
            if (! $car = $this->carRepository->storeNewCar((array) $data)) {
                throw new \Exception(trans('api.cars_http_status_code_400'));
            }

            return [
                'code' => (int) 201,
                'message' => trans('api.cars_http_status_code_201'),
                'data' => $car
            ];
        } catch (\Exception $ex) {
            return [
                'code' => (int) 400,
                'message' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Get a specific car from collection.
     *
     * @param $id
     * @return array
     */
    public function findCarById(string $id) : array
    {
        try {
            $entity = $this->carRepository->findCarById($id);

            if (! $entity) {
                throw new \Exception(trans('api.cars_http_status_code_404'));
            }

            return [
                'code' => (int) 200,
                'message' => trans('api.cars_http_status_code_200'),
                'data' => $entity
            ];
        } catch (\Exception $ex) {
            return [
                'code' => (int) 404,
                'message' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Update a specific car from collection.
     *
     * @param $id
     * @param array $data
     * @return array
     */
    public function updateCarById(string $id, array $data) : array
    {
        try {
            $entity = $this->carRepository->findCarById($id);

            if (! $entity) {
                throw new \Exception(trans('api.cars_http_status_code_404'));
            }

            if (! $this->carRepository->updateCarById($id, (array) $data)) {
                throw new \Exception(trans('api.cars_http_status_code_404'));
            }

            return [
                'code' => (int) 200,
                'message' => trans('api.cars_http_status_code_200'),
            ];
        } catch (\Exception $ex) {
            return [
                'code' => (int) 404,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * Delete specific car from collection.
     *
     * @param $id
     * @return array
     */
    public function deleteCarById(string $id) : array
    {
        try {
            $entity = $this->carRepository->findCarById($id);

            if (! $entity) {
                throw new \Exception(trans('api.cars_http_status_code_404'));
            }

            if (! $this->carRepository->deleteCarById($id)) {
                throw new \Exception(trans('api.cars_http_status_code_400'));
            }

            return [
                'code' => (int) 200,
                'message' => trans('api.cars_http_status_code_200'),
            ];
        } catch (\Exception $ex) {
            return [
                'code' => (int) 404,
                'message' => $ex->getMessage()
            ];
        }
    }
}