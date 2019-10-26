<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CarrosService;
use App\Http\Resources\CarrosResource;
use Exception;

class CarrosController extends Controller
{
    private $service;
    public function __construct(CarrosService $service)
    {
        $this->service = $service;
    }

    public function all()
    {
        try {
            $carros = $this->service->all();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                "msg" => utf8_encode($e->getMessage())
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $carros,
            "msg" => 'Todos os carros listados com sucesso'
        ]);
    }

    public function find($id)
    {
        try {
            $carro = $this->service->find($id);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                "msg" => 'Erro ao tentar consular carro'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $carro,
            "msg" => 'Carro consultado com sucesso'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only('marca','modelo','ano');
            $carro = $this->service->store($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                "msg" => utf8_encode($e->getMessage())
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $carro,
            "msg" => 'Carro salvo com sucesso'
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->only('marca','modelo','ano');
            $carro = $this->service->update($data,$id);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                "msg" => 'Erro ao editar o carro'
            ]);
        }


        return response()->json([
            'success' => true,
            'data' => $carro,
            "msg" => 'Carro editado com sucesso'
        ]);
    }

    public function delete($id)
    {
        try {
            $carro = $this->service->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                "msg" => 'Erro ao tentar deletar o carro'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $carro,
            "msg" => 'Carro deletado com sucesso'
        ]);
    }
}
