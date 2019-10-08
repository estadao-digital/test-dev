<?php

namespace App\Http\Controllers\Api;

use App\Crud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /**
	 * @var Crud
	 */
	private $carros;

    public function __construct(Crud $carros)
    {
        $this->crud = $carros;
    }
    public function index()
    {
        return response()->json($this->crud->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            try {
                $productData = $request->all();
                $this->crud->create($productData);
                $return = ['data' => ['msg' => 'Carro cadastrado com sucesso!']];
                return response()->json($return, 201);
            } catch (\Exception $e) {
                if(config('app.debug')) {
                    return response()->json(ApiError::errorMessage($e->getMessage(), 1010), 500);
                }
                return response()->json(ApiError::errorMessage('Houve um erro ao realizar operação de salvar', 1010),  500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Crud $id)
    {
        $carros = $this->crud->find($id);
    	if(! $carros) return response()->json(ApiError::errorMessage('Carro não encontrado!', 4040), 404);
    	$data = ['data' => $carros];
	    return response()->json($data);
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
        try {
			$productData = $request->all();
			$carros    = $this->crud->find($id);
			$carros->update($productData);
			$return = ['data' => ['msg' => 'Carro atualizado com sucesso!']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1011),  500);
			}
			return response()->json(ApiError::errorMessage('Houve um erro ao realizar operação de atualizar', 1011), 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Crud $id)
    {
        try {
			$id->delete();
			return response()->json(['data' => ['msg' => 'Carro: ' . $id->marca . ' removido com sucesso!']], 200);
		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 1012),  500);
			}
			return response()->json(ApiError::errorMessage('Houve um erro ao realizar operação de remover', 1012),  500);
		}
	}
}
