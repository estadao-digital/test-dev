<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\BrandResource;
use App\Http\Controllers\BaseController;

class BrandController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return $this->sendResponse(BrandResource::collection($brands), 'Marcas Retornadas com sucesso!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|min:2'
        ],
        [
            'name.required' => 'Preencha o nome.',
            'name.min' => 'O nome deve conter 2 ou mais caracteres.'
        ]);

        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());
        }

        $brand = Brand::create($input);

        return $this->sendResponse(new BrandResource($brand), 'Marca criada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        if (is_null($brand)) {
            return $this->sendError('Marca não Encontrada.');
        }
        return $this->sendResponse(new BrandResource($brand), 'Marca recuperada com sucesso.');
        */
        $brand = $this->exists($id);

        if($brand){
            return $this->sendResponse(new BrandResource($brand), 'Marca recuperada com sucesso.');
        }else{
            return $this->sendError('Marca Não encontrada.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|min:2'
        ],
        [
            'name.required' => 'Preencha o nome.',
            'name.min' => 'O nome deve conter 2 ou mais caracteres.'
        ]);

        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());
        }

        $brand->name = $input['name'];
        if($this->exists($input['id'])){
            $brand->save();
            return $this->sendResponse(new BrandResource($brand), 'Marca atualizada com sucesso.');
        }else{
            return $this->sendError('Marca Não encontrada.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = $this->exists($id);

        if($brand){
            $brand->delete();
            return $this->sendResponse([], 'Marca excluida com sucesso.');
        }else{
            return $this->sendError('Marca Não encontrada.');
        }
    }

    public function exists($id){
        $brand = Brand::find($id);
        if($brand)
            return $brand;
        else
            return false;
    }
}
