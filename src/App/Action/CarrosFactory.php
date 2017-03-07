<?php

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

class CarrosFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CarrosAction($container->get(Adapter::class));
    }
}
