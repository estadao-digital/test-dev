<?php

namespace app\controllers;

use app\lib\Response;
use app\lib\rest\Controller;
use app\models\Marcas;

class MarcaController extends Controller
{
    public function actionIndex()
    {
        $marcas = Marcas::findAll();
        Response::sendResponse(Response::OK, $marcas, ['returnFormat'=>'json']);
    }
}