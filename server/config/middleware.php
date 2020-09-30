<?php

use Slim\App;

return function (App $app) {
	$settings = $app->getContainer()->get('settings');

	$app->addBodyParsingMiddleware();

	$app->addRoutingMiddleware();

	$app->addErrorMiddleware(
		$settings['displayErrorDetails'],
		$settings['logErrors'],
		$settings['logErrorDetails']
	);
};
