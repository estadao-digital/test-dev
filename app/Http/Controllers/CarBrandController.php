<?php

namespace App\Http\Controllers;

use App\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CarBrand::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $carBrand = new CarBrand;
        $carBrand->name = $request->get('name');

        $carBrand->save();
        return response($carBrand, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CarBrand  $carBrand
     * @return \Illuminate\Http\Response
     */
    public function show(CarBrand $carBrand)
    {
        return $carBrand;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CarBrand  $carBrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarBrand $carBrand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $carBrand->name = $request->get('name');

        $carBrand->save();
        return $carBrand;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CarBrand  $carBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarBrand $carBrand)
    {
        //
        $carBrand->delete();
        return response(null, 204);
    }
}
