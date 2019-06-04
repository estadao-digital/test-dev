<?php

class CarroValidator
{
  private static $attributes = [
    'modelo' => 'Modelo',
    'marca'  => 'Marca',
    'ano'    => 'Ano'
  ];

  private static $rules = [];

  private static $messages = [
    'required' => 'O campo :attribute é obrigatorio.',
    'numeric' => 'O campo :attribute deve ser numerico.',
    'ano.max' => 'O campo Ano é deve conter 4 digitos e estar entre os anos de 1900 e 2100.',
    'ano.min' => 'O campo Ano é deve conter 4 digitos e estar entre os anos de 1900 e 2100.',
  ];

  public static function store($input)
  {
    self::$rules = [
      'modelo' => 'required|string|min:2|max:50',
      'marca' => 'required|numeric',
      'ano' => 'required|numeric|min:1900|max:2100',
    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }

  public static function update($id, $input)
  {
    self::$rules = [
      'modelo' => 'required|string|min:2|max:50',
      'marca' => 'required|numeric',
      'ano' => 'required|numeric|min:1900|max:2100',
    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }
}
