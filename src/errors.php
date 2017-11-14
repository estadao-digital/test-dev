<?php

$container = $app->getContainer();

$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        $statusCode = is_integer($exception->getCode()) ? $exception->getCode() : 500;
        return $container['response']->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json')
            ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};

$container['phpErrorHandler'] = function ($container) {
    return function ($request, $response, $error) use ($container) {
        return $container['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->withJson([
                "message" => $error->getMessage(),
                "line" => $error->getLine(),
                "codigo" => $error->getCode()
            ], 500);
    };
};

$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $container['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'application/json')
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
    };
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->withJson(['message' => 'Page not found']);
    };
};
