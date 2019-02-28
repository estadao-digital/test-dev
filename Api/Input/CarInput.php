<?php

namespace Api\Input;

use Api\Input\AbstractInput;

class CarInput extends AbstractInput
{
    private const DEFAULT_MODEL = '';
    private const DEFAULT_YEAR = 0;
    private const DEFAULT_BRAND_NAME = '';

    public function getModel(): string
    {
        return $this->getParameter('model', self::DEFAULT_MODEL);
    }

    public function getYear(): int
    {
        return $this->getParameter('year', self::DEFAULT_YEAR);
    }

    public function getBrandName(): string
    {
        return $this->getParameter('brand', self::DEFAULT_BRAND_NAME);
    }
}
