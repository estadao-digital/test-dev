<?php

namespace Api\Input;

abstract class AbstractInput
{
    protected $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    protected function getParameter($keyParam, $default)
    {
        return isset($this->parameters[$keyParam]) ? $this->parameters[$keyParam] : $default;
    }
}