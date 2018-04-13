<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controllers;
/**
 * User: Smith
 * Date: 4/12/2018
 * Time: 12:51 AM
 */
class CarroApiController extends Controller
{

    use \App\Http\Controllers\ApiControllerTrait;

    protected $model;
    protected $relationships = ['marca'];

    public function __construct(\App\Carro $model)
    {
        $this->model = $model;
    }



}