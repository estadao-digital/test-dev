<?php

namespace Api\Routes;

abstract class AbstractRoutes
{
    protected $conatiner;
    protected $defaultPath;

    public function __construct(string $defaultPath, array $container)
    {
        $this->defaultPath = $defaultPath;
        $this->container = $container;
        $this->run($this->getUrl());
    }

    abstract protected function getRoutes(): array;

    protected function run($url): void
    {
        $routes = $this->getRoutes();
        

        array_walk($routes, function($route) use ($url){
            $route['route'] = $this->defaultPath . $route['route'];

            if ($url == $route['route'] && $route['method'] === $_SERVER['REQUEST_METHOD']) {
                $controller = $route['controller'];
                $action = $route['action'];
                $controller->$action();
            }
        });
    }

    protected function getUrl(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
