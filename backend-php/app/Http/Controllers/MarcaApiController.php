<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controllers;
/**
 * User: Smith
 * Date: 4/12/2018
 * Time: 12:51 AM
 */
class MarcaApiController extends Controller
{

    use \App\Http\Controllers\ApiControllerTrait;

    protected $model;

    public function __construct(\App\Marca $model)
    {
        $this->model = $model;
    }



}