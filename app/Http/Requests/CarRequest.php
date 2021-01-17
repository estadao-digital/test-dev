<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'marca' => 'required|integer',
            'modelo' => 'required|max:255',
            'ano' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'É necessário informar o campo :attribute com o valor correto.',
            'max' => 'O modelo do carro deve ter no máximo 255 caracteres.'
        ];
    }
}
