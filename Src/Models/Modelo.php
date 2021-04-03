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
            $objects = $this->find()->fetch(true);
            
            $list = [];

            foreach($objects as $obj){
                $list[] = $obj->data();
            }

            return $list;     
        }

        public function marca(): Marca
        {
            return (new Marca())->findById($this->marca_id);
        }
    }