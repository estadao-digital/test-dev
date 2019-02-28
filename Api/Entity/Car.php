<?php

namespace Api\Entity;

use Api\Entity\Brand;

class Car
{
    private $id;
    private $model;
    private $year;
    private $brand;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): int
    {
        $this->id = $id;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model)
    {
        $this->model = $model;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year)
    {
        $this->year = $year;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}