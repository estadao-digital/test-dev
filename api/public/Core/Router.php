<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

use App\Config\Routes;
use App\Core\HandleJson;

/**
 * Class Router
 * 
 * @package App\Core
 */
class Router
{   
    private $httpMethodsAllow = [
        'GET',
        'POST',
        'PUT',
        'DELETE'
    ];

    public function __call($name, $args)
    {
        list($route, $method) = $args;        

        if (!in_array(strtoupper($name), $this->httpMethodsAllow)) {
            $this->invalidMethodHandler();
            return false;
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    public function resolve()
    {
        $this->loadRoutes();
    }

    /**
     * Load all routes
     * 
     * @return void
     */
    private function loadRoutes(): void
    {
        $path = __DIR__ . '/../Config/';
        
        $file = $path . 'Routes.php';

        if (!file_exists($file)) {
            // TODO
            return;
        }

        $route = $this;

        require $file;
    }

    /**
     * Remove trailing forward slashes from the right of the route.
     * 
     * @param string $route
     * @return string
     */
    private function formatRoute($route): string
    {
        $result = rtrim($route, '/');
        return ($result === '') ? '/' : $result;
    }

    /**
     * Handles the error when it is an invalid method
     * 
     * @return void
     */
    private function invalidMethodHandler(): void
    {
        echo HandleJson::response(HandleJson::STATUS_METHOD_ALLOWED, 'Invalid Method!');
    }

    /**
     * Handles the error when it is a standard request
     * 
     * @return void
     */
    private function defaultRequestHandler(): void
    {        
        echo HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Default Request Not Found!');
    }
}