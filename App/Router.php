<?php

declare(strict_types=1);

namespace App;

class Router
{
    private $notFoundHandler;

    private array $routes = [];

    private string $requested_method = '';

    private ?string $base_path = null;

    private string $base_url = '';

    private string $namespace = '';

    /**
     *
     * @param object|callable $handler
     */
    public function get(string $endpoint, $handler): self
    {
        $this->match(['GET'], $endpoint, $handler);

        return $this;
    }

    /**
     *
     * @param object|callable $handler
     */
    public function post(string $endpoint, $handler): self
    {
        $this->match(['POST'], $endpoint, $handler);

        return $this;
    }

    /**
     *
     * @param object|callable $handler
     */
    public function delete(string $endpoint, $handler): self
    {
        $this->match(['DELETE'], $endpoint, $handler);

        return $this;
    }

    /**
     *
     * @param object|callable $handler
     */
    public function put(string $endpoint, $handler): self
    {
        $this->match(['PUT'], $endpoint, $handler);

        return $this;
    }

    public function group(string $route, callable $handler): self
    {
        $base_url = $this->base_url;

        $this->base_url .= $route;

        call_user_func($handler);

        $this->base_url = $base_url;

        return $this;
    }

    /**
     *
     * @param object|callable $handler
     */
    public function setNotFound($handler): self
    {
        $this->notFoundHandler = $handler;

        return $this;
    }

    /**
     *
     * @param object|callable $handler
     */
    public function match(array $methods, string $endpoint, $handler): self
    {
        $route = $this->base_url . '/' . trim($endpoint, '/');
        $route = $this->base_url ? rtrim($route, '/') : $route;

        if (false === empty($methods)) {
            foreach ($methods as $method) {
                $this->routes[strtoupper($method)][] = [
                    'endpoint'  => $route,
                    'handler'   => $handler,
                ];
            }
        }

        return $this;
    }

    public function setBasePath(string $base_path): self
    {
        $this->base_path = $base_path;

        return $this;
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getRequestMethod(): string
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? '';

        if ($method === 'HEAD') {
            ob_start();

            $method = 'GET';
        } elseif ($method === 'POST') {
            $headers = $this->getHeaders();

            if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], ['PUT', 'DELETE'])) {
                $method = $headers['X-HTTP-Method-Override'];
            }
        }

        return $method;
    }

    public function getHeaders(): array
    {
        $headers = [];

        if (function_exists('getallheaders')) {
            $headers = getallheaders();

            if ($headers !== false) {
                return $headers;
            }
        }

        foreach ($_SERVER as $name => $value) {
            if ((substr($name, 0, 5) === 'HTTP_') || ($name === 'CONTENT_TYPE') || ($name === 'CONTENT_LENGTH')) {
                $key = str_replace([' ', 'Http'], ['-', 'HTTP'], ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));

                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    public function dispatch(): bool
    {
        $this->requested_method = $this->getRequestMethod();

        $handled = 0;

        if (isset($this->routes[$this->requested_method])) {
            $handled = $this->handle($this->routes[$this->requested_method]);
        }

        if ($handled === 0) {
            $this->triggerNotFound();
        }

        $method = $_SERVER['REQUEST_METHOD'] ?? '';

        if ($method == 'HEAD') {
            ob_end_clean();
        }

        return $handled !== 0;
    }

    private function triggerNotFound(): void
    {
        if ($this->notFoundHandler) {
            $this->invoke($this->notFoundHandler);
        } else {
            if (empty($_SERVER['SERVER_PROTOCOL'])) {
                return;
            }

            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        }
    }

    private function handle(array $routes): int
    {
        $uri        = $this->getCurrentUri();
        $handled    = 0;

        foreach ($routes as $route) {
            $route['endpoint'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['endpoint']);

            if (preg_match_all('#^' . $route['endpoint'] . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
                $matches = array_slice($matches, 1);

                $params = array_map(function ($match, $index) use ($matches) {
                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        if ($matches[$index + 1][0][1] > -1) {
                            return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                        }
                    }

                    return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                $this->invoke($route['handler'], $params);

                ++$handled;

                break;
            }
        }

        return $handled;
    }

    private function invoke($handler, $params = []): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } elseif (stripos($handler, '@') !== false) {
            list($controller, $method) = explode('@', $handler);

            if ($this->namespace !== '') {
                $controller = $this->namespace . '\\' . $controller;
            }

            try {
                $reflectedMethod = new \ReflectionMethod($controller, $method);
                
                if ($reflectedMethod->isPublic() && (!$reflectedMethod->isAbstract())) {
                    if ($reflectedMethod->isStatic()) {
                        forward_static_call_array([$controller, $method], $params);
                    } else {
                        $controller = new $controller();

                        call_user_func_array([$controller, $method], $params);
                    }
                }
            } catch (\ReflectionException $exception) {
                throw $exception->getMessage();
            }
        }
    }

    private function getCurrentUri(): string
    {
        $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), strlen($this->getBasePath()));

        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        return '/' . trim($uri, '/');
    }

    private function getBasePath(): string
    {
        if ($this->base_path === null) {
            $this->base_path = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }

        return $this->base_path;
    }
}
