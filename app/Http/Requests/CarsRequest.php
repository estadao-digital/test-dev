<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;

class CarsRequest extends FormRequest

{
    public function wantsJson()
    {
        return true;
    }


    public function authorize()
    {
        return true;
    }

    public function rules()

    {
        return [
            'marca' => 'required',
            'modelo' => 'required',
            'ano' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'marca.required' => 'Preencha o campo marca',
            'modelo.required' => 'Preencha o campo modelo',
            'ano.required' => 'Preencha o campo ano',
        ];
    }

    public function response(array $errors) {
        return Response::create($errors, 403);
    }

}