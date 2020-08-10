<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use JMS\Serializer\SerializerBuilder as Serializer;
use \Exception;
use Ramsey\Uuid\Uuid;
use App\Models\Vehicle;

/**
 * this class has the function of being a repository of read and write data
 * Class DatabaseRepository
 * @package App\Services
 */
class DatabaseRepository
{

    private const DB_File_Name = 'vehicles.json';
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('local');
        $this->createDatabase();
    }

    public function getAll()
    {
        try {
            $contents = $this->disk->get(static::DB_File_Name);
//            return json_decode($contents, true);
            $serializer = Serializer::create()->build();
            $vehicles = $serializer->deserialize($contents, 'array<App\Models\Vehicle>', 'json');
            return $vehicles;
        } catch (Exception $ex) {
            Log::critical($ex->getMessage());
        }
        return [];
    }

    public function find($columnName, $value)
    {
        $vehicles = $this->getAll();
        $method = 'get' . ucfirst($columnName);
        $result = array_filter($vehicles, function ($item) use ($method, $value) {
            return strcasecmp($value, call_user_func(array($item, $method))) === 0;
        });

        return reset($result);
    }

    public function store($data)
    {
        $vehicles = $this->getAll();
        $vehicle = new Vehicle(Uuid::uuid4(), $data['model'], $data['year'], $data['image']);
        $vehicles[] = $vehicle;
        $this->saveDB($vehicles);
        return $vehicle;
    }

    public function setVehicle($id, $data)
    {
        $vehicles = $this->getAll();
        $vehicleId = $this->findVehicleById($id, $vehicles);
        if ($vehicleId < 0) {
            return false;
        }
        $vehicle = $vehicles[$vehicleId];
        $vehicle->setModel($data['model']);
        $vehicle->setYear($data['year']);
        $vehicle->setImage($data['image']);
        $this->saveDB($vehicles);
        return $vehicles[$vehicleId];
    }

    public function removeVehicle($id)
    {
        $vehicles = $this->getAll();
        $vehicleId = $this->findVehicleById($id, $vehicles);
        if ($vehicleId < 0) {
            return false;
        }
        unset($vehicles[$vehicleId]);
        $this->saveDB($vehicles);
        return true;
    }

    private function createDatabase()
    {
        if ($this->disk->exists(static::DB_File_Name)) {
            return;
        }
        $this->disk->put(static::DB_File_Name, '[]');
    }

    private function findVehicleById($id, $vehicles)
    {
        $key = -1;
        foreach ($vehicles as $index => $item) {
            $vehicleId = call_user_func(array($item, 'getId'));
            if (strcasecmp($id, $vehicleId) === 0) {
                $key = $index;
                break;
            }
        }
        return $key;
    }

    private function saveDB($vehicles)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($vehicles, 'json');
        $this->disk->put(static::DB_File_Name, $jsonContent);
    }
}
