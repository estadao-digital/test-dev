<?php
define('__BASE__', __DIR__.'/../');

include __BASE__.'vendor/autoload.php';

//configurando o request
$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

try {
    $dispatcher = new Phroute\Phroute\Dispatcher(include __BASE__.'config/rotas.php');
    echo $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
} catch(Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    die('Ação não localizada');
}