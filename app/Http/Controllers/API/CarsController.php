<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CarsRequest;
use App\Model\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CarsController extends Controller
{
    protected $model = '';

    public function __construct()
    {
        $this->model = new Car();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars    = $this->model->query()
            ->leftJoin('manufacturers as mn', 'mn.id', 'cars.manufacturer_id')
            ->select(['cars.id','model as modelo', 'year as ano', 'mn.name as marca' ])
            ->orderBy('cars.id', 'desc')
            ->get();

        if(!$cars) {
            return response()->json([
                'content'   => '',
                'message'   => 'Registro não encontrado.',
            ], 404);
        }

        return response()->json(['content' => $cars, 'message'=>'']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarsRequest $request)
    {


        $cars   = $this->model;

         $cars->create([
            'manufacturer_id'     => $request['marca'],
            'model'               => $request['modelo'],
            'year'                => $request['ano'],
         ]);


        return response()->json(['content' => $cars, 'message'=>'Cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cars    = $this->model->query()
            ->leftJoin('manufacturers as mn', 'mn.id', 'cars.manufacturer_id')
            ->select(['cars.id','model as modelo', 'year as ano', 'mn.id as marca' ])
            ->where('cars.id', $id)->first();


        if(!$cars) {
            return response()->json([
                'content'   => '',
                'message'   => 'Registro não encontrado.',
            ], 404);
        }

        return response()->json(['content' => $cars, 'message'=>'']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarsRequest $request, $id)
    {
        $cars    = $this->model->where('id', $id)->first();

        if(!$cars) {
            return response()->json([
                'content'   => '',
                'message'   => 'Registro não encontrado.',
            ], 404);
        }

        $cars->update([
            'manufacturer_id'     => $request['marca'],
            'model'               => $request['modelo'],
            'year'                => $request['ano'],
        ]);

        return response()->json(['content' => $cars, 'message'=>'Alterado com sucesso!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cars    = $this->model->where('id','=', $id)->first();

        if(!$cars) {
            return response()->json([
                'content'   => '',
                'message'   => 'Registro não encontrado.',
            ], 404);
        }

        $cars->delete();

        return response()->json(['content' => $cars, 'message'=>'Deletado com sucesso!'], 201);
    }
}
