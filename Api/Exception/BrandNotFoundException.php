<?php

namespace Api\Exception;

class BrandNotFoundException extends \Exception
{
    public function __construct(string $brandName)
    {
        parent::__construct(
            "BrandNotFoundException: The brand $brandName is not exists."
        );
    }
}