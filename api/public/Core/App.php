<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

/**
 * Class App
 * 
 * @package App\Core
 */
class App
{
    /**
     * @var object
     */
    protected $controller;

    /**
     * @var string
     */
    protected $method;
    
    /**
     * @var bool
     */
    protected $page404;
    
    /**
     * @var array
     */
    protected $params;

    public function __construct()
    {
        $parseUrl = $this->parseUrl();

        $this->page404 = false;

        $this->getController($parseUrl);
        $this->getMethod($parseUrl);
        $this->getParams($parseUrl);

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Get params this url
     * 
     * @return array
     */
    private function parseUrl(): array
    {
        return explode('/', substr(filter_input(INPUT_SERVER, 'REQUEST_URI'), 1));
    }

    /**
     * Load the controller if it exists inside the controllers folder
     * 
     * @param array $url
     * 
     * @return void
     */
    private function getController($url = []): void
    {
        $nameController = 'Default';        

        if (isset($url[0]) && !empty($url[0])) {        
            if (file_exists(__DIR__ . '/../Controller/' . ucfirst($url[0]) . 'Controller.php')) {
                $nameController = ucfirst($url[0]);
            } else {
                $this->page404 = true;
            }
        }

        $class = "\App\Controller\\{$nameController}Controller";
        
        $this->controller = new $class;
    }
    
    /**
     * Load method
     * 
     * @param array $url
     * 
     * @return void
     */
    private function getMethod($url = []): void
    {
        $nameMethod = 'index';

        if (isset($url[1]) && !empty($url[1])) {
            if (method_exists($this->controller, $url[1]) && !$this->page404) {
                $nameMethod = $url[1];
            } else {
                $nameMethod = 'notFound';
            }
        }

        $this->method = $nameMethod;
    }

    /**
     * Load params
     * 
     * @param array $url
     * 
     * @return void
     */
    private function getParams($url = []): void
    {
        $params = [];
        
        if (count($url) > 2) {
            $params = array_slice($url, 2);
        }

        $this->params = $params;
    }
}