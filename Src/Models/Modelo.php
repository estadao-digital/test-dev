<?php

    namespace Src\Models;

    use CoffeeCode\DataLayer\DataLayer;

    class Modelo extends Datalayer
    {
        public function __construct()
        {
            parent::__construct('Modelos', ['marca_id', 'nome']);
        }

        public function getAll(){
            $modelos = $this->find()->fetch(true);
            $lista = [];
            /** @var $modelo Modelo */
            foreach ($modelos as $modelo)
            {
                $lista[] =  $modelo->data();
            }
            return $lista;
        }

        public function getByMarca($marca_id)
        {
            $modelos = $this
                ->find("marca_id = :marca_id", "marca_id={$marca_id}")
                ->fetch(true);
            /** @var $modelo Modelo */
            foreach ($modelos as $modelo)
            {
                $lista[] =  $modelo->data();
            }
            return $lista;
        }

        public function marca(): Marca
        {
            return (new Marca())->findById($this->marca_id);
        }
    }