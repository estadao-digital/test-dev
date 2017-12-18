<?php

namespace Cars\ShowCase\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cars\Car\Services\CarService;
use App\Helpers\ArrayHelper;

class ShowCaseController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view( 'cars.index' );
    }

    public function gridView( Request $request )
    {
        $service = new CarService();
        return view ( 'cars.grid.grid' , [ 
                                            'cars' => $service->getFilterList( $request->all() ) 
                                         ] );
    }

    public function formGridView( Request $request )
    {
        $helper = new ArrayHelper();
        $service = new CarService();
        return view ( 'cars.grid.filter' , [ 
                                            'manufacturers' => $helper->generateKeySimpleValueByList( 'id', 
                                                                                            'name' , 
                                                                                            $service->getAllManufacturer() ,
                                                                                            'Selecione')
                                         ] );
    }

}