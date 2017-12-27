<?php

namespace App\Http\Controllers\API;

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
        $cars    = $this->model->all();

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
    public function store(Request $request)
    {
        $data = $request->all();


        try{
            $cars   = $this->model;
            $cars->fill($data);
            $cars->save();
        }catch (\Exception $e){
            return response()->json(['content' => '', 'message'=>'Erro ao cadastrar imóvel.']);
        }

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
        $cars    = $this->model->where('id', $id)->first();

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
    public function update(Request $request, $id)
    {
        $cars    = $this->model->where('id', $id)->first();

        if(!$cars) {
            return response()->json([
                'content'   => '',
                'message'   => 'Registro não encontrado.',
            ], 404);
        }

        $cars->fill($request->all());
        $cars->save();
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
