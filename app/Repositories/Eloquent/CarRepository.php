<?php declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\Repository;
use App\Models\Car;

class CarRepository extends Repository
{
    /**
     * Default property for car model.
     *
     * @var $carModel
     */
    protected $carModel;

    /**
     * Set default instance of car model.
     *
     * @param Car $carModel
     */
    public function __construct(Car $carModel)
    {
        $this->carModel = $carModel;
    }

    /**
     * Get all items from collection.
     *
     * @param array $columns
     * @return mixed
     */
    public function getAllCars()
    {
        return $this->carModel->get();
    }

    /**
     * Create a new collection item.
     *
     * @param array $data
     * @return mixed
     */
    public function storeNewCar(array $data)
    {
        return $this->carModel::create($data);
    }

    /**
     * Get a specific item from collection.
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findCarById(string $id)
    {
        return $this->carModel::where('id', $id)->first();
    }

    /**
     * Update specific item from collection.
     *
     * @param $id
     * @param array $data
     * @param string $attribute
     * @return mixed
     */
    public function updateCarById(string $id, array $data)
    {
        return $this->carModel::where('id', $id)
            ->update($data);
    }

    /**
     * Delete specific item from collection.
     *
     * @param  $id
     * @return mixed
     */
    public function deleteCarById(string $id)
    {
        return $this->carModel::destroy($id);
    }
}