<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class CarValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'brand_id' => 'required',
            'model'    => 'required',
            'year'     => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'brand_id' => 'required',
            'model'    => 'required',
            'year'     => 'required',
        ],
    ];

    protected $messages = [
        'brand_id.required' => 'A Marca é obrigatória.',
        'model.required' => 'O Modelo é obrigatório.',
        'year.required' => 'O Ano é obrigatório.', 
    ];
}