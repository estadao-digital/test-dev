<?php

declare(strict_types=1);

namespace Cars\Tests;

use App\Router;

use \PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = (new Router())->setNamespace('App');
    }

    public function testGet(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->get('/', 'Cars@index'));
    }

    public function testPost(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->post('/carros', 'Cars@add'));
    }

    public function testDelete(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->delete('/carros/(\d+)', 'Cars@delete'));
    }

    public function testPut(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->put('/carros/(\d+)', 'Cars@update'));
    }

    public function testGroup(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->group('/carros', function() {}));
    }

    public function testSetNotFound(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->setNotFound(function() {}));
    }

    public function testMatch(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->match(['get'], '/', 'Cars@index'));
    }

    public function testSetBasePath(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->setBasePath(''));
    }

    public function testSetNamespace(): void
    {
        $this->assertInstanceOf(Router::class, $this->router->setNamespace(''));
    }

    public function testGetRequestMethod(): void
    {
        $this->assertIsString($this->router->getRequestMethod());
    }

    public function testGetHeaders(): void
    {
        $this->assertIsArray($this->router->getHeaders());
    }

    public function testDispatch(): void
    {
        $this->assertIsBool($this->router->dispatch());
    }
}
