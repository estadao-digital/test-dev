<?php

namespace App\Modules\Cars\Infra\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Modules\Cars\Services\ListCarsService;
use App\Modules\Cars\Services\CreateCarService;
use App\Modules\Cars\Services\FindCarService;
use App\Modules\Cars\Services\UpdateCarService;
use App\Modules\Cars\Services\DeleteCarService;
use Exception;

final class CarsController
{
	public function index(Request $request, Response $response): Response
	{
		try {
			$listCars = new ListCarsService();

			$cars = $listCars->execute();

			$response->getBody()->write(json_encode([
				'cars' => $cars,
			]));

			return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
		} catch (Exception $e) {
			$response->getBody()->write(json_encode([
				'error' => [
					'status' => $e->getCode(),
					'message' => $e->getMessage(),
				],
			]));

			return $response->withStatus($e->getCode())->withHeader('Content-Type', 'application/json');
		}
	}

	public function create(Request $request, Response $response): Response
	{
		try {
			$data = (array) $request->getParsedBody();

			if (empty($data['brand_id'])) {
				throw new Exception('The field \'brand_id\' is required.', 400);
			}

			if (empty($data['model'])) {
				throw new Exception('The field \'model\' is required.', 400);
			}

			if (empty($data['year'])) {
				throw new Exception('The field \'year\' is required.', 400);
			}

			$createCar = new CreateCarService();

			$car = $createCar->execute($data);

			$response->getBody()->write(json_encode([
				'car' => $car,
			]));

			return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
		} catch (Exception $e) {
			$response->getBody()->write(json_encode([
				'error' => [
					'status' => $e->getCode(),
					'message' => $e->getMessage(),
				],
			]));

			return $response->withStatus($e->getCode())->withHeader('Content-Type', 'application/json');
		}
	}

	public function show(Request $request, Response $response, $id): Response
	{
		try {
			$findCar = new FindCarService();

			$car = $findCar->execute($id);

			$response->getBody()->write(json_encode([
				'car' => $car,
			]));

			return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
		} catch (Exception $e) {
			$response->getBody()->write(json_encode([
				'error' => [
					'status' => $e->getCode(),
					'message' => $e->getMessage(),
				],
			]));

			return $response->withStatus($e->getCode())->withHeader('Content-Type', 'application/json');
		}
	}

	public function update(Request $request, Response $response, $id): Response
	{
		try {
			$data = (array) $request->getParsedBody();

			if (empty($data['brand_id'])) {
				throw new Exception('The field \'brand_id\' is required.', 400);
			}

			if (empty($data['model'])) {
				throw new Exception('The field \'model\' is required.', 400);
			}

			if (empty($data['year'])) {
				throw new Exception('The field \'year\' is required.', 400);
			}

			$updateCar = new UpdateCarService();

			$car = $updateCar->execute($data, $id);

			$response->getBody()->write(json_encode([
				'car' => $car,
			]));

			return $response->withStatus(202)->withHeader('Content-Type', 'application/json');
		} catch (Exception $e) {
			$response->getBody()->write(json_encode([
				'error' => [
					'status' => $e->getCode(),
					'message' => $e->getMessage(),
				],
			]));

			return $response->withStatus($e->getCode())->withHeader('Content-Type', 'application/json');
		}
	}

	public function destroy(Request $request, Response $response, $id): Response
	{
		try {
			$deleteCar = new DeleteCarService();

			$deleteCar->execute($id);

			$response->getBody()->write('');

			return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
		} catch (Exception $e) {
			$response->getBody()->write(json_encode([
				'error' => [
					'status' => $e->getCode(),
					'message' => $e->getMessage(),
				],
			]));

			return $response->withStatus($e->getCode())->withHeader('Content-Type', 'application/json');
		}
	}
}
