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
            'modelo' => 'required',
            'marca' => 'required',
            'ano' => 'numeric|required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(
            [
                "success" => false,
                "data" => [],
                "msg" => "Verifique os campos",
                "error" => $errors
            ]
        ));
    }

    public function messages()
    {
        return [
            'modelo.required' => 'Modelo é um campo obrigatório',
            'marca.required' => 'Marca é um campo obrigatório',
            'ano.numeric' => 'Ano deve ser um número',
            'ano.required' => 'Ano é um campo obrigatório',
        ];
    }
}