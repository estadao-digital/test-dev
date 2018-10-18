<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarService;

header("Access-Control-Allow-Origin: *");

class CarController extends Controller
{
    /**
     * Default property for car service.
     *
     * @var $carService
     */
    protected $carService;

    /**
     * Set a default instance for service.
     *
     * @param CarService $carService
     */
    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * Get all cars from collection.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : object
    {
        $response = $this->carService->getAllCars();

        return response()->json($response, $response['code']);
    }

    /**
     * Create a new car into collection.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) : object
    {
        $data = $request->all();
        $response = $this->carService->storeNewCar((array) $data);

        return response()->json($response, $response['code']);
    }

    /**
     * Get a specific car from collection.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(string $id) : object
    {
        $response = $this->carService->findCarById($id);

        return response()->json($response, $response['code']);
    }

    /**
     * Update specific car from collection.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id) : object
    {
        $data = $request->all();
        $response = $this->carService->updateCarById($id, (array) $data);

        return response()->json($response, $response['code']);
    }

    /**
     * Delete specific car from collection.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function delete(string $id) : object
    {
        $response = $this->carService->deleteCarById($id);

        return response()->json($response, $response['code']);
    }
}
