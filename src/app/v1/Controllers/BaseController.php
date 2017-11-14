<?php

namespace App\v1\Controllers;

class BaseController
{
	protected $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}