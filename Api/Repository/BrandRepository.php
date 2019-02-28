<?php

namespace Api\Repository;

use Api\Config\Connection;

class BrandRepository
{
    const TABLE_NAME = 'brands'; 

    public function findByName(string $name)
    {
        $sql = ('SELECT * FROM ' . self::TABLE_NAME . ' WHERE name = :name');
        $stmt = Connection::prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->fetch();
    }
}
