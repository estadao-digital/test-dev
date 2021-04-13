<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

use App\Config\Routes;
use App\Core\HandleJson;
use App\Core\Request;

/**
 * Class Router
 * 
 * @package App\Core
 */
class Router
{   
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var array
     */
    private $httpMethodsAllow = [
        'GET',
        'POST',
        'PUT',
        'DELETE'
    ];

    /**
     * Router construct
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __call($name, $args)
    {
        list($route, $method) = $args;        

        if (!in_array(strtoupper($name), $this->httpMethodsAllow)) {
            echo HandleJson::response(HandleJson::STATUS_METHOD_ALLOWED, 'Invalid Method!');
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Resolve routes
     * 
     * @return string
     */
    public function resolve(): ?string
    {
        if ($this->loadRoutes()) {
            $this->propertyName = strtolower($this->request->requestMethod);

            if (property_exists($this, $this->propertyName)) {
                $this->methodDictionary = $this->{$this->propertyName};            
                
                $this->formatedRoute = $this->formatRoute(parse_url($this->request->requestUri)['path']);
                
                $this->handleMethodDictionary();

                $this->renderContent();
            }
        }

        return '';
    }

    /**
     * Render Content
     * 
     * @return string
     */
    private function renderContent(): ?string
    {
        if (array_key_exists($this->formatedRoute, $this->methodDictionary)) {
            $method = $this->methodDictionary[$this->formatedRoute];
            $type = gettype($method);

            switch ($type) {
                case 'object':
                    echo call_user_func_array($method, [$this->request]);
                    break;

                case 'string':
                    echo $this->handleController($method);
                    break;
            }
        }

        return '';
    }
    
    /**
     * Handle Controller content
     * 
     * @param string $method
     * 
     * @return string
     */
    private function handleController($method): ?string
    {
        preg_match('/@/', $method, $matches);        

        if ($matches) {
            $expMethod = explode('@', $method);

            list($controllerClass, $controllerMethod) = $expMethod;
            
            if ($controllerClass && $controllerMethod) {
                $path = __DIR__ . '/../Controller';
                $file = "{$path}/{$controllerClass}.php";

                if (!file_exists($file)) {
                    return HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Controller Not Found!');
                } else {
                    $class = "\App\Controller\\{$controllerClass}";
                    $controller = new $class($this->request);

                    if (method_exists($controller, $controllerMethod)) {
                        return $controller->{$controllerMethod}();
                    }
                }
            }
        }

        return '';
    }
    
    /**
     * Handle Method Dictionary of routes
     * 
     * @return void
     */
    private function handleMethodDictionary(): void
    {
        $methodDictionaryKeys = array_keys($this->methodDictionary);
        
        foreach($methodDictionaryKeys as $methodDictionaryKey) {
            $expFormatedRoute = explode('/', $this->formatedRoute);
            $expMethodDictionaryKey = explode('/', $methodDictionaryKey);

            if (count($expFormatedRoute) == count($expMethodDictionaryKey)) {
                $isMatch = false;

                foreach($expMethodDictionaryKey as $index => $item) {
                    preg_match('/\{(.*?)\}/s', $item, $matches);
                    
                    if ($matches) {
                        $isMatch = true;
                        $expMethodDictionaryKey[$index] = $expFormatedRoute[$index];
                    }
                }

                if ($isMatch) {
                    $methodDictionaryNewKey = implode('/', $expMethodDictionaryKey);
                    
                    $this->methodDictionary[$methodDictionaryNewKey] = $this->methodDictionary[$methodDictionaryKey];
                    
                    unset($this->methodDictionary[$methodDictionaryKey]);
                }
            }
        }
    }

    /**
     * Load all routes
     * 
     * @return bool
     */
    private function loadRoutes(): bool
    {        
        $file = __DIR__ . '/../Config/Routes.php';

        if (!file_exists($file)) {
            echo HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Routes File Not Found!');
            return false;
        }

        $route = $this;

        require $file;

        return true;
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
}