<?php

    namespace Src\Models;

    use CoffeeCode\DataLayer\DataLayer;

    class Marca extends Datalayer
    {
        public function __construct()
        {
            parent::__construct('Marcas', ['nome']);
        }

    }