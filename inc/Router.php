<?php

namespace Core;

class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @return string
     */
    public function method()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';
    }

    /**
     * @return string
     */
    public function uri()
    {
        $self = isset($_SERVER['PHP_SELF']) ? str_replace('index.php/', '', $_SERVER['PHP_SELF']) : '';
        $uri = isset($_SERVER['REQUEST_URI']) ? explode('?', $_SERVER['REQUEST_URI'])[0] : '';

        if ($self !== $uri) {
            $peaces = explode('/', $self);
            array_pop($peaces);
            $start = implode('/', $peaces);
            $search = '/' . preg_quote($start, '/') . '/';
            $uri = preg_replace($search, '', $uri, 1);
        }

        return $uri;
    }

    /**
     * is triggered when invoking inaccessible methods in an object context.
     *
     * @param $name string
     * @param $arguments array
     * @return mixed
     * @link http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.methods
     */
    function __call($name, $arguments)
    {
        return $this->on($name, isset($arguments[0]) ? $arguments[0] : '', isset($arguments[1]) ? $arguments[1] : '');
    }

    /**
     * @param $method
     * @param $path
     * @param $callback
     * @return $this
     */
    public function on($method, $path, $callback)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $uri = substr($path, 0, 1) !== '/' ? '/' . $path : $path;
        $pattern = str_replace('/', '\/', $uri);
        $route = '/^' . $pattern.'\/?$'. '$/';

        $this->routes[$method][$route] = $callback;

        return $this;
    }

    /**
     * The __invoke method is called when a script tries to call an object as a function.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     *
     * @param $method
     * @param $uri
     * @return mixed
     */
    function __invoke($method, $uri)
    {
        return $this->run($method, $uri);
    }

    /**
     * @param $method
     * @param $uri
     * @return mixed|null
     */
    public function run($method, $uri)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $route => $callback) {

            if (preg_match($route, $uri, $parameters)) {
                array_shift($parameters);
                return $this->call($callback, $parameters);
            }
        }
        return null;
    }

    /**
     * @param $callback
     * @param $parameters
     * @return mixed
     */
    public function call($callback, $parameters)
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $parameters);
        }
        return null;
    }

}