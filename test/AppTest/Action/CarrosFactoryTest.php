<?php

namespace AppTest\Action;

use App\Action\CarrosAction;
use App\Action\CarrosFactory;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CarrosFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $dbAdapter;

    /** @var ContainerInterface */
    private $container;

    protected function setUp()
    {
        $this->dbAdapter = $this->prophesize(DbAdapter::class);

        $this->container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(RouterInterface::class);

        $this->container->get(RouterInterface::class)->willReturn($router);
    }

    public function testFactoryWithoutTemplate()
    {
        $factory = new CarrosFactory();
        $this->container->has(TemplateRendererInterface::class)->willReturn(false);

        $this->assertTrue($factory instanceof CarrosFactory);

        $carros = $factory($this->dbAdapter->reveal());

        $this->assertTrue($carros instanceof CarrosAction);
    }

    public function testFactoryWithTemplate()
    {
        $factory = new CarrosFactory();
        $this->container->has(TemplateRendererInterface::class)->willReturn(true);
        $this->container
            ->get(TemplateRendererInterface::class)
            ->willReturn($this->prophesize(TemplateRendererInterface::class));

        $this->assertTrue($factory instanceof CarrosFactory);

        $carros = $factory($this->dbAdapter->reveal());

        $this->assertTrue($carros instanceof CarrosAction);
    }
}
