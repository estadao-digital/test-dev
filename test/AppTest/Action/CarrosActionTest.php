<?php

namespace AppTest\Action;

use App\Action\CarrosAction;
use App\Action\CarrosFactory;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Interop\Container\ContainerInterface;
use Interop\Container\Con;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;


class CarrosActionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerInterface */
    private $dbInterface;
/** @var ContainerInterface */
    private $container;

    protected function setUp()
    {
//        $this->container = $this->prophesize(ContainerInterface::class);
        $this->dbInterface = $this->prophesize(AdapterInterface::class);
//        $this->container = new ContainerInterface;
//        $this->container = $this->prophesize(ContainerInterface::class);
//        $dbAdapter = $this->prophesize(DbAdapter::class);
//
//        $this->container->get(RouterInterface::class)->willReturn($dbAdapter);
    }

    public function testResponse()
    {
        $carrosAction = new CarrosAction($this->dbInterface->reveal());
        $response = $carrosAction(new ServerRequest(['/carros']), new Response(), function () {
        });
        $json = json_decode((string) $response->getBody());

        $this->assertTrue($response instanceof Response);
        $this->assertTrue($response instanceof Response\JsonResponse);
        $this->assertTrue(isset($json->carros));
    }
}
