<?php

namespace Models;

use Abstracts\AbstractDAO;

class CarsDAO extends AbstractDAO
{
    function __construct()
    {
        parent::__construct('Entities\Cars');
    }
}
