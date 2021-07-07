<?php

namespace App\Http\Controllers\Brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Domain\Brand\BrandRepository;

class BrandController extends Controller
{

    protected $brand;

    public function __construct(BrandRepository $brand)
    {

        $this->brand = $brand;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brand->listBrands();

        return $brands;
    }


}
