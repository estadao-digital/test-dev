<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ano' => $this->ano,
            'marca_id' => $this->marca_id,
            'modelo' => $this->modelo,
            'marca' => $this->marca
        ];
    }
}
