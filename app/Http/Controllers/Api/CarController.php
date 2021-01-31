<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Model\Car;
use App\Services\CarService;
use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="localhost:8083",
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Desafio Test Dev",
 *         description="A proposta desta aplicação é efetuar o cadastro de carros de acordo com a marca, modelo e ano.",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="rro.oliveira@gmail.com"
 *         )
 *     ),
 * )
 */
class CarController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * @SWG\Get (
     *     path="/api/carros",
     *     summary="Exibe a listagem de carros cadastrados.",
     *     @SWG\Response(response=200, description="Sem resposta de retorno."),
     * )
     */
    public function index()
    {
        $cars = Car::latest()->with('car_brand')->get();
        return response()->json($cars, 200);
    }

    public function create(Request $request)
    {
        //
    }

    /**
     * @SWG\Post (
     *     path="/api/carros",
     *     summary="Efetua o cadastro do carro.",
     *     @SWG\Response(response=200, description="Carro cadastrado com sucesso."),
     *     @SWG\Response(response=400, description="
     *                                              O código da marca informado está incorreto.
     *                                              O ano do carro informado está incorreto.
     *                                              Erro ao efetuar o cadastro do carro.
     *                                              "),
     *          @SWG\Parameter (
     *              description="Código da marca do carro",
     *              name="marca",
     *              in="query",
     *              required=true,
     *              type="integer"
     *          ),
     *          @SWG\Parameter (
     *              description="Modelo do carro",
     *              name="modelo",
     *              in="query",
     *              required=true,
     *              type="string",
     *          ),
     *          @SWG\Parameter (
     *              description="Ano de fabricação do carro",
     *              name="ano",
     *              in="query",
     *              required=true,
     *              type="integer",
     *          ),
     * )
     */
    public function store(CarRequest $request)
    {
        $request->only('marca', 'modelo', 'ano');
        $data = $request->validated();

        $car = $this->carService->registerCar($data['marca'], $data['modelo'], $data['ano']);

        if ($car instanceof \RuntimeException) {
            return response()->json(['message' => $car->getMessage()], 400);
        }
        return response()->json(['message' => 'Carro cadastrado com sucesso.'], 200);
    }

    /**
     * @SWG\Get (
     *     path="/api/carros/{id}",
     *     summary="Exibe as informações do carro de acordo com o id informado",
     *     @SWG\Response(response=200, description="Sem resposta de retorno."),
     *     @SWG\Response(response=400, description="
     *                                              Erro ao localizar o register do carro informado.
     *                                              "),
     *          @SWG\Parameter (
     *              description="Código do register do carro",
     *              name="id",
     *              in="query",
     *              required=true,
     *              type="integer"
     *          ),
     * )
     */
    public function show($id)
    {
        $car = $this->carService->getCarById($id);

        if ($car instanceof \RuntimeException) {
            return response()->json(['message' => $car->getMessage()], 400);
        }

        return response()->json($car, 200);
    }

    /**
     * @SWG\Put (
     *     path="/api/carros/{id}",
     *     summary="Efetua atualização das informações do carro.",
     *     @SWG\Response(response=200, description="Carro atualizado com sucesso."),
     *     @SWG\Response(response=400, description="
     *                                              O código da marca informado está incorreto.
     *                                              O ano do carro informado está incorreto.
     *                                              Erro ao localizar o register do carro informado.
     *                                              Erro ao atualizar as informações do carro.
     *                                              "),
     *          @SWG\Parameter (
     *              description="Código do register do carro",
     *              name="id",
     *              in="query",
     *              required=true,
     *              type="integer"
     *          ),
     *          @SWG\Parameter (
     *              description="Código da marca do carro",
     *              name="marca",
     *              in="query",
     *              required=true,
     *              type="integer"
     *          ),
     *          @SWG\Parameter (
     *              description="Modelo do carro",
     *              name="modelo",
     *              in="query",
     *              required=true,
     *              type="string",
     *          ),
     *          @SWG\Parameter (
     *              description="Ano de fabricação do carro",
     *              name="ano",
     *              in="query",
     *              required=true,
     *              type="integer",
     *          ),
     * )
     */
    public function update(CarRequest $request, $id)
    {
        $request->only('marca', 'modelo', 'ano');
        $data = $request->validated();

        $car = $this->carService->alterCarInformation($id, $data['marca'], $data['modelo'], $data['ano']);

        if ($car instanceof \RuntimeException) {
            return response()->json(['message' => $car->getMessage()], 400);
        }

        return response()->json(['message' => 'Carro atualizado com sucesso.'], 200);
    }

    /**
     * @SWG\Delete (
     *     path="/api/carros/{id}",
     *     summary="Efetua a exclusão do cadastro do carro.",
     *     @SWG\Response(response=200, description="Carro excluído com sucesso."),
     *     @SWG\Response(response=400, description="
     *                                              Erro ao localizar o register do carro informado.
     *                                              "),
     *          @SWG\Parameter (
     *              description="Código do register do carro",
     *              name="id",
     *              in="query",
     *              required=true,
     *              type="integer"
     *          ),
     * )
     */
    public function destroy($id)
    {
        $car = $this->carService->deleteCar($id);

        if ($car instanceof \RuntimeException) {
            return response()->json(['message' => $car->getMessage()], 400);
        }

        return response()->json(['message' => 'Carro excluído com sucesso.'], 200);
    }
}
