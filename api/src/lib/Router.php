<?php

namespace app\lib;

use app\lib\Response;
use app\lib\web\Session;

class Router
{

    protected $routes;
    private $routeSnapshot;

    function __construct(array $route)
    {
        Session::open();
        $this->setRoutes();
        $this->setRouteSnapshot($route);
        $route = $this->checkRoute();
        $this->callAction($route);
    }

    private function setRouteSnapshot(array $route) : void {
        $this->routeSnapshot = $route;
    }

    private function getRouteSnapshot () : array {
        return $this->routeSnapshot;
    }

    private function setRoutes()
    {
        $this->routes = include_once __DIR__ . '/../../config/routes.php';
    }

    private function checkRoute()
    {
        $findRoute = false;

        foreach ($this->routes as $configRoute) {
            $route = $this->getRouteSnapshot();
            if ($this->hasParams($configRoute['url'])) {
                $route['url'] = $this->prepareRoute($configRoute['url'], $route['url']);
            }
            
            if ($configRoute['url'] == $route['url'] && $configRoute['method'] == $route['method']) {
                $findRoute = true;
                $route = $configRoute;
                break;
            }
        }

        if (!$findRoute) {
            Response::sendResponse(Response::NOT_FOUND, Response::NOT_FOUND);
        }

        return $route;
    }

    private function callAction(array $route)
    {
        $path = $route['controller']['namespace'];
        $controller = new $path;

        if ($route['hasAuth'] ?? false) {
            $controller->isAuthenticated();
        }

        $action = 'action' . ucfirst($route['controller']['action']);
        $controller->$action();
    }

    /**
     * Check route has params
     * 
     * @param string $url Config URL
     * 
     * @return bool
     */
    private function hasParams(string $url): bool
    {
        $url = explode('/', $url);
        $params = array_filter($url, function ($value) {
            return stripos($value, ':') !== false;
        });

        return count($params) >= 1 ? true : false;
    }

    private function prepareRoute(string $configUrl, string $routeUrl)
    {
        $configUrl = explode('/', $configUrl);
        $routeUrl = explode('/', $routeUrl);

        if (count($configUrl) === count($routeUrl)) {
            $params = array_filter($configUrl, function ($value) {
                return stripos($value, ':') !== false;
            });

            foreach ($params as $key => $value) {
                $paramKey = str_replace(':', '', $value);
                $paramValue = $routeUrl[$key] ?? null;
                $_GET[$paramKey] = $paramValue;
                unset($routeUrl[$key]);
                $routeUrl[$key] = $value;
            }
        }
        
        ksort($routeUrl);
        return implode('/', $routeUrl);
    }
}
