<?php

namespace App\Http\Resources;

use App\Marca;

use Illuminate\Http\Resources\Json\Resource;

class CarroResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'modelo' => $this->modelo,
            'marca' => Marca::find($this->marca_id)->marca, 
            'ano' => $this->ano
        ];
    }
}
