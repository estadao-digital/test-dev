<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 25/10/19
 * Time: 14:35
 */

namespace App\Http\Resources;
use \Illuminate\Http\Resources\Json\Resource;

class CarrosResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'ano' => $this->ano
        ];
    }
}