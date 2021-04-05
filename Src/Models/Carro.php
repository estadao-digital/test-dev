<?php

    namespace Src\Models;

    use CoffeeCode\DataLayer\DataLayer;

    class Carro extends Datalayer
    {
        public function __construct()
        {
            parent::__construct('Carros', ['placa', 'modelo_id', 'ano'], 'id', false);
        }

        public function getAll(){
            $objects = $this->find()->fetch(true);
            
            $list = [];

            /** 
             * O coffeeCode opta por não usar joins nas ,
             * Com ele cada linha de retorno é um objeto,
             * então aqui estamos adicionando os objets de Marca e Modelo 
             * para cada Carro
             */
            foreach($objects as $obj){
                /** @var $modelo Modelo */
                /** @var $marca Marca */
                $modelo = $obj->modelo();
                
                $marca = $modelo->marca();
                
                $obj->Modelo = $modelo->data();
                $obj->Marca = $marca->data();

                $list[] = $obj->data();
            }

            return $list;     
        }

        public function modelo(): Modelo
        {
            return (new Modelo())->findById($this->modelo_id);
        }
    }