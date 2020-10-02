<?php

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as RouteCollectorProxy;
use App\Modules\Cars\Infra\Http\Controllers\CarsController;

return function (App $app) {
	$app->group('/cars', function (RouteCollectorProxy $group) {
		$group->get('', [CarsController::class, 'index']);

		$group->post('', [CarsController::class, 'create']);

		$group->get('/{id}', [CarsController::class, 'show']);

		$group->put('/{id}', [CarsController::class, 'update']);

		$group->delete('/{id}', [CarsController::class, 'destroy']);
	});
};
