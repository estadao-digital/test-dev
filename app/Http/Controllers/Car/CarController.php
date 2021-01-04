<?php

namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use Domain\Car\CarRepository;


class CarController extends Controller
{

    protected $car;


    public function __construct(CarRepository $car)
    {

        $this->car = $car;

    }

    public function home()
    {
        return view('car.home');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = $this->car->listCars();

        return $cars;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = json_decode($request->getContent(), true);

        $rules = $this->car->getValidationRules();
        $validator = Validator::make($formData, $rules);

        if($validator->fails()) {
          return ['400'];
        }

        $res = $this->car->storeCar($formData);


        return $res;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = $this->car->showCar($id);

        return $car;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formData = json_decode($request->getContent(), true);

        $rules = $this->car->getValidationRules();
        $validator = Validator::make($formData, $rules);

        if($validator->fails()) {
          return ['400'];
        }

        $res = $this->car->updateCar($id, $formData);

        return $res;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $res = $this->car->deleteCar($id);

        return $res;

    }
}
