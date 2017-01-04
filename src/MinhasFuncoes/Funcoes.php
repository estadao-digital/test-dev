<?php

/**
 * Created by PhpStorm.
 * User: rafael.lemos
 * Date: 04/01/2017
 * Time: 14:00
 */
class Funcoes
{

    public static function asset($url) {
        return 'public/'.$url;
    }

    public static function listaMarcas() {
        return [
            1 => 'Audi',
            2 => 'BMW',
            3 => 'Chery',
            4 => 'Chevrolet',
            5 => 'Citroën',
            6 => 'Ferrari',
            7 => 'Fiat',
            8 => 'Ford',
            9 => 'Mercedes-Benz',
           10 => 'Nissan',
           11 => 'Peugeot',
           12 => 'Renault',
           13 => 'Toyota',
           14 => 'Volkswagen',
        ];
    }

}