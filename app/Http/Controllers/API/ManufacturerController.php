<?php

namespace App\Http\Controllers\API;

use App\Model\Car;
use App\Model\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ManufacturerController extends Controller
{
    protected $model = '';

    public function __construct()
    {
        $this->model = new Manufacturer();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufacturer    = $this->model->all();

        if(!$manufacturer) {
            return response()->json([
                'content'   => '',
                'message'   => 'Registro não encontrado.',
            ], 404);
        }

        return response()->json(['content' => $manufacturer, 'message'=>'']);
    }

}
