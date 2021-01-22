<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CarResource;
use App\Models\Car;

class CarController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::with('brand')->with('model')->get();

        return response([ 'cars' => CarResource::collection($cars), 'message' => 'Successfully'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),

        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation error']);
        }

        $car = Car::create($data);

        return response(['car' => new CarResource($car), 'message' => 'Created successfully'], 201);
    }

    /**
     * @param Car $car
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return response(['car' => new ProjectResource($car), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @param Request $request
     * @param Car $car
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation error']);
        }

        $car->update($data);

        return response(['project' => new CarResource($car), 'message' => 'Updated successfully'], 200);
    }

    /**
     * @param Car $car
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return response(['message' => 'Deleted successfully']);
    }
}
