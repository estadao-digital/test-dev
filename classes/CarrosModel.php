<?php

class CarrosModel extends ActiveRecord\Model { 
    public static $table_name = 'carro';
}
/**
 * $carro = new Carro;

#var_dump($carro,get_class_methods($carro),$carro->table_name());die;
$carro->ano = 2015;
$carro->marca = 'TOYOTA';
$carro->modelo = 'COROLLA';
$carro->save();


 */
