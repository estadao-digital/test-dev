<?php

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as RouteCollectorProxy;
use App\Modules\Brands\Infra\Http\Controllers\BrandsController;

return function (App $app) {
  $app->group('/brands', function (RouteCollectorProxy $group) {
    $group->get('', [BrandsController::class, 'index']);

    $group->post('', [BrandsController::class, 'create']);
  });
};
