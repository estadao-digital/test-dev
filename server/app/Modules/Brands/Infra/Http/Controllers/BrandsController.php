<?php

namespace App\Modules\Brands\Infra\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Modules\Brands\Services\ListBrandsService;
use App\Modules\Brands\Services\CreateBrandService;
use Exception;

final class BrandsController
{
  public function index(Request $request, Response $response): Response
  {
    try {
      $listBrands = new ListBrandsService();

      $brands = $listBrands->execute();

      $response->getBody()->write(json_encode([
        'brands' => $brands,
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

      if (empty($data['name'])) {
        throw new Exception('The field name is required', 400);
      }

      $createBrand = new CreateBrandService();

      $brand = $createBrand->execute($data);

      $response->getBody()->write(json_encode([
        'brand' => $brand,
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
}
