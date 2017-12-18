<?php

namespace Cars\Admin\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cars\Car\Services\CarService;
use Cars\Car\Exceptions\CarEditException;
use App\Helpers\ArrayHelper;

class CarController extends Controller
{
    public function __construct()
    {
    }

    public function createModal()
    {
        $service = new CarService();
        $helper = new ArrayHelper();
        return view( 'cars.admin.create', [ 
                            'manufacturers' => $helper->generateKeySimpleValueByList( 'id', 
                                                                                            'name' , 
                                                                                            $service->getAllManufacturer() ,
                                                                                            'Selecione')
                            ] 
                        );
    }

    public function fabricanteById( Request $request )
    {
        $service = new CarService();
        return response()->json( $service->getManufacturerById( $request->id ) );
    }
    
    public function editModal( Request $request )
    {
        $service = new CarService();
        $helper = new ArrayHelper();
        return view( 'cars.admin.edit', [ 
                            'car' => $service->edit( $request->id ),
                            'manufacturers' => $helper->generateKeySimpleValueByList( 'id', 
                                                                                            'name' , 
                                                                                            $service->getAllManufacturer() ,
                                                                                            'Selecione')
                            ] 
                        );
    }

    public function findById( Request $request )
    {
        $service = new CarService();
        return response()->json( $service->edit( $request->id ) );
    }

    public function update( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new CarService();
            $service->update( $request->id , $request->all() );
            \DB::commit();
            $return['message'] = 'Carro editado com sucesso';
            return response()->json( $return );
        }catch( CarEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }
    
    public function remove( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new CarService();
            $service->remove( $request->id );
            \DB::commit();
            $return['message'] = 'Carro excluido com sucesso';
            return response()->json( $return );
        }catch( CarEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }

    public function create( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new CarService();
            $service->create( $request->all() );
            $return['message'] = 'Carro criado com sucesso';
            \DB::commit();
            return response()->json( $return );
        }catch( CarEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }
}
