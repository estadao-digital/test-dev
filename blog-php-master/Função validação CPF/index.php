<?php

function validateCPF($number) {

    $cpf = preg_replace('/[^0-9]/', "", $number);

    if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
        return false;
    }

    $number_quantity_to_loop = [9, 10];

    foreach ($number_quantity_to_loop as $item) {

        $sum = 0;
        $number_to_multiplicate = $item + 1;
    
        for ($index = 0; $index < $item; $index++) {

            $sum += $cpf[$index] * ($number_to_multiplicate--);
    
        }

        $result = (($sum * 10) % 11);

        if ($cpf[$item] != $result) {
            return false;
        }

    }

    return true;

}