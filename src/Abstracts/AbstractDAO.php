<?php

namespace Abstracts;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

abstract class AbstractDAO
{
    private $entityManager;
    private $entityPath;

    function __construct($entityPath)
    {
        $this->entityPath = $entityPath;
        $this->entityManager = $this->createEntityManager();
    }

    function createEntityManager()
    {
        $path = [
            $this->entityPath
        ];

        $devMode = true;

        $config = Setup::createAnnotationMetadataConfiguration($path, $devMode);

        $conn = array(
            'dbname'    => 'estadao',
            'user'      => 'estadao',
            'password'  => 'secret',
            'host'      => 'localhost',
            'driver'    => 'pdo_mysql'
        );

        return EntityManager::create($conn, $config);
    }

    function insert($car)
    {
        $this->entityManager->persist($car);
        $this->entityManager->flush();
    }

    function update($car)
    {
        $this->entityManager->update($car);
        $this->entityManager->flush();
    }

    function delete($id)
    {
        $this->entityManager->remove($id);
        $this->entityManager->flush();
    }

    function find($id)
    {
        $this->entityManager->find($this->entityPath, $id);
        $this->entityManager->flush();
    }

    function findAll()
    {
        $collection = $this->entityManager
        ->gerRepository($this->entityPath)
        ->findAll();

        $data = [];

        foreach($collection as $object)
        {
            $data [] = $object;
        }

        return $data;
    }

}
