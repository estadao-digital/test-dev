<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use App\Services\BrandService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * @var CarService
     */
    private $service;

    /**
     * @var BrandService
     */
    private $brandService; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CarService $service, BrandService $brandService)
    {
        $this->service      = $service;
        $this->brandService = $brandService;        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = $this->service->store($request->all());        

        return [
            'success'     => $service['success'],
            'description' => $service['message'],
            'data'        => $service['data']
        ];
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
        $service = $this->service->update($request->all(), $id);        

        return [
            'success'     => $service['success'],
            'description' => $service['message'],
            'data'        => $service['data']
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {       
        $service = $this->service->destroy($id);      

        return [
            'success'     => $service['success'],
            'description' => $service['message'],
            'data'        => $service['data']
        ];
    }
}
