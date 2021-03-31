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

    function __construct(Request $request)
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

    public function resolve()
    {
        if (!$this->loadRoutes()) {
            return false;
        }

        $this->propertyName = strtolower($this->request->requestMethod);

        $this->methodDictionary = $this->{$this->propertyName};
        
        $this->formatedRoute = $this->formatRoute(parse_url($this->request->requestUri)['path']);

        if (property_exists($this, $this->propertyName)) {
            $this->handleMethodDictionary();
            
            if (array_key_exists($this->formatedRoute, $this->methodDictionary)) {
                $method = $this->methodDictionary[$this->formatedRoute];
    
                echo call_user_func_array($method, [$this->request]);
            }
        }
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