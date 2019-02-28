<?php

namespace Api\Repository;

use Api\Entity\Car;
use Api\Config\Connection;

class CarRepository
{
    const TABLE_NAME = 'cars'; 

    public function fetchAll(): array
    {
        $this->sql = ('
            SELECT c.id, c.model, c.year, b.name as brand FROM ' . self::TABLE_NAME . ' c
            INNER JOIN ' . BrandRepository::TABLE_NAME . ' b on c.brandId = b.id
        ');

        $stmt = Connection::prepare($this->sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findById(int $id)
    {
        $this->sql = ('
            SELECT c.id, c.model, c.year, b.name as brand FROM ' . self::TABLE_NAME . ' c
            INNER JOIN ' . BrandRepository::TABLE_NAME . ' b on c.brandId = b.id
            WHERE c.id = :id
        ');

        $stmt = Connection::prepare($this->sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchObject(Car::class);
    }

    public function insert(Car $car): void
    {
        $model = $car->getModel();
        $year = $car->getYear();
        $brandId = $car->getBrand()->getId();

        $sql = ('
            INSERT INTO ' . self::TABLE_NAME . '(model, year, brandId)
            VALUES (:model, :year, :brandId)
        ');

        $stmt = Connection::prepare($sql);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':brandId',$brandId );
        
        $stmt->execute();
    }

    public function update(Car $car, int $id): void
    {
        $model = $car->getModel();
        $year = $car->getYear();
        $brandId = $car->getBrand()->getId();

        $sql = ('
            UPDATE ' . self::TABLE_NAME . ' SET 
            model = :model,
            year = :year, 
            brandId = :brandId
            WHERE id = :id
        ');

        $stmt = Connection::prepare($sql);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':brandId',$brandId );
        $stmt->bindParam(':id',$id );
        
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $sql = ('DELETE FROM ' . self::TABLE_NAME . ' WHERE id = :id');

        $stmt = Connection::prepare($sql);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    }
}
