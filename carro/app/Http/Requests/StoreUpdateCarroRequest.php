<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCarroRequest extends FormRequest
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
            'marca' => 'required|min:2|max:255',
            'modelo' => 'required|min:2|max:255',
            'ano' => 'required|min:2|max:4',
        ];
    }

    public function messages()
    {
        return [
            'marca.required' => 'Por favor, preencha o campo Marca',
            'marca.min' => 'Utilize um mínimo de dois caracteres',
            'modelo.required' => 'Por favor, preencha o campo Modelo',
            'modelo.min' => 'Utilize um mínimo de dois caracteres',
            'ano.required' => 'Por favor, preencha o campo Ano',
            'ano.min' => 'Formato permitido de dois ou quatro dígitos',
        ];
    }
}
