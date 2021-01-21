<?php
namespace App\Api\v1\Cars;

use App\Modules\Cars\Provider\CarsServiceProvider;
use Illuminate\Http\Request;

class CarsEndpoint
{
    private $carsServiceProvider;
    
    function __construct(CarsServiceProvider $carsServiceProvider)
    {
        $this->carsServiceProvider = $carsServiceProvider;
    }
    
    public function getAllCars()
    {
        return $this->carsServiceProvider->getAllCars();
    }
    
    public function getCarById($id)
    {
        return $this->carsServiceProvider->getCarById($id);
    }

    public function store(Request $request)
    {
        return $this->carsServiceProvider->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->carsServiceProvider->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->carsServiceProvider->destroy($id);
    }
}