<?php

    namespace Src\Models;

    use CoffeeCode\DataLayer\DataLayer;

    class Marca extends Datalayer
    {
        public function __construct()
        {
            parent::__construct('Marcas', ['nome']);
        }

        public function getAll(){
            $marcas = $this->find()->fetch(true);
            $lista = [];
            /** @var $marca Marca */
            foreach ($marcas as $marca)
            {
                $lista[] =  $marca->data();
            }
            return $lista;
        }
    }