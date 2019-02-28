<?php

namespace Api\Service;

use Api\Entity\Car;
use Api\Entity\Brand;
use Api\Input\CarInput;
use Api\Repository\CarRepository;
use Api\Repository\BrandRepository;
use Api\Exception\CarNotFoundException;
use Api\Exception\BrandNotFoundException;

class CarService
{
    private $carRepository;
    private $brandRepository;

    public function __construct(CarRepository $carRepository, BrandRepository $brandRepository)
    {
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
    }

    public function fetchAll(): array
    {
        $cars = $this->carRepository->fetchAll();

        return $cars;
    }

    public function findCar($id): Car
    {
        $car = $this->carRepository->findById($id);

        if (empty($car)) {
            throw new CarNotFoundException($id);
        }

        return $car;
    }

    public function createCar(CarInput $carInput): Car
    {
        $car = $this->bindCar($carInput);
        $this->carRepository->insert($car);

        return $car;
    }

    public function editCar(CarInput $carInput, int $id): Car
    {
        $this->findCar($id);
        $car = $this->bindCar($carInput);
        $this->carRepository->update($car, $id);

        return $car;
    }

    public function deleteCar(int $id): void
    {
        $car = $this->findCar($id);
        $this->carRepository->delete($id);
    }

    private function bindCar(CarInput $carInput): Car
    {
        $car = new Car();
        $brand = $this->getBrand($carInput->getBrandName());
        $car->setModel($carInput->getModel());
        $car->setYear($carInput->getYear());
        $car->setBrand($brand);

        return $car;
    }

    private function getBrand(string $brandName): Brand
    {
        $brandData = $this->brandRepository->findByName($brandName);
        
        if (empty($brandData)) {
            throw new BrandNotFoundException($brandName);
        }

        $brand = new Brand();
        $brand->setId($brandData->id);
        $brand->setName($brandData->name);

        return $brand;
    }
}
