<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarroFormRequest extends FormRequest
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
            'marca'     => 'required',
            'modelo'    => 'required|min:3|max:30',
            'ano'       => 'required|numeric'
        ];
    }
    
    public function messages() {
        return [
            'marca.required'    => 'O campo Marca deve ser preenchido.',
            'modelo.required'   => 'O campo Modelo deve ser preenchido.',
            'modelo.between'    => 'O campo Modelo deve ser entre 3 e 30 dígitos.',
            'ano.required'      => 'O campo Ano deve ser preenchido.',
        ];
    }
}
