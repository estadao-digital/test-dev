<?php

namespace App\Http\Controllers;

use App\Services\BrandService;

class BrandController extends Controller
{
    /**
     * @var BrandService
     */
    private $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BrandService $service)
    {
        $this->service = $service;
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
}
