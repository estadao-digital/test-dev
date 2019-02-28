<?php

namespace Api\Provider;

interface InterfaceProvider
{
    public function register(array $container): array;
}