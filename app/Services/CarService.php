<?php


namespace App\Services;


use App\Model\Car;
use App\Repositories\CarRepository;

class CarService
{
    public $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function registerCar(int $idBrand, string $model, int $year)
    {
        try {
            $dataChecked = $this->checkingDataForRegistration($idBrand, $model, $year);

            if ($dataChecked instanceof \RuntimeException) {
                throw $dataChecked;
            }

            $carRegistration = $this->processRegistration($idBrand, $model, $year);
            if ($carRegistration instanceof \RuntimeException) {
                throw $carRegistration;
            }

            return true;

        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function checkingDataForRegistration(int $idBrand, string $model, int $year)
    {
        try {
            $brandService = app()->make(BrandService::class);
            $brandChecked = $brandService->checkBrandById($idBrand);

            if (!$brandChecked) {
                throw new \RuntimeException('O código da marca informado está incorreto.');
            }

            //1886 DATA DE FABRICAÇÃO DO PRIMEIRO CARRO NO MUNDO.
            if ($year > date('Y') || $year < '1886') {
                throw new \RuntimeException('O ano do carro informado está incorreto.');
            }
        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function processRegistration(int $idBrand, string $model, int $year)
    {
        try {
            $carRegistration = $this->carRepository->create([
                'id_brand' => $idBrand,
                'model' => $model,
                'year' => $year
            ]);

            if (!$carRegistration instanceof Car) {
                throw new \RuntimeException('Erro ao efetuar o cadastro do carro.');
            }

            return $carRegistration;
        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function alterCarInformation(int $idCar, int $idBrand, string $model, int $year)
    {
        try {
            $car = $this->checkingDataForUpdate($idCar, $idBrand, $model, $year);

            if ($car instanceof \RuntimeException) {
                throw $car;
            }

            $carUpdated = $this->carRepository->update($idCar, [
                'id_brand' => $idBrand,
                'model' => $model,
                'year' => $year
            ]);

            if (!$carUpdated) {
                throw new \RuntimeException('Erro ao atualizar as informações do carro.');
            }

        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function checkingDataForUpdate(int $idCar, int $idBrand, string $model, int $year)
    {
        try {
            $dataChecked = $this->checkingDataForRegistration($idBrand, $model, $year);

            if ($dataChecked instanceof \RuntimeException) {
                throw $dataChecked;
            }

            $car = $this->carRepository->find($idCar);

            if (is_null($car) || $car->count() <= 0) {
                throw new \RuntimeException('Erro ao localizar o register do carro informado.');
            }

            return $car;

        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function deleteCar(int $idCar)
    {
        try {

            $car = $this->carRepository->find($idCar);

            if (is_null($car) || $car->count() <= 0) {
                throw new \RuntimeException('Erro ao localizar o register do carro informado.');
            }

            return $this->carRepository->destroy($idCar);

        } catch (\RuntimeException $e) {
            return $e;
        }
    }

    public function getCarById(int $idCar)
    {
        try {
            $car = $this->carRepository->find($idCar);

            if (is_null($car) || $car->count() <= 0) {
                throw new \RuntimeException('Erro ao localizar o register do carro informado.');
            }

            return $car;

        } catch (\RuntimeException $e) {
            return $e;
        }
    }
}
