<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 26/10/19
 * Time: 00:54
 */

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarroRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'modelo' => 'string|required',
            'marca' => 'string|required',
            'ano' => 'numeric|required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        foreach ($errors as $error) {
            throw new HttpResponseException(response()->json(
                [
                    "success" => false,
                    "data" => [],
                    "msg" => $error
                ]
            ));
        }
    }

    public function messages()
    {
        return [
            'modelo.string' => 'Modelo deve ser uma string',
            'modelo.required' => 'Modelo é um campo obrigatório',
            'marca.required' => 'Marca é um campo obrigatório',
            'marca.string' => 'Marca deve ser uma string',
            'ano.numeric' => 'Ano deve ser um número',
            'ano.required' => 'Ano é um campo obrigatório',
        ];
    }
}