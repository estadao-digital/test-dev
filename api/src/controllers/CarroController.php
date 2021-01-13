<?php

namespace app\controllers;

use app\lib\exception\ValidateException;
use app\lib\Request;
use app\lib\Response;
use app\lib\rest\Controller;
use app\models\Carros;
use app\models\Marcas;
use Exception;

class CarroController extends Controller
{
    public function actionIndex()
    {

        $carros = Carros::findAll();
        Response::sendResponse(Response::OK, $carros, ['returnFormat' => 'json']);
    }

    public function actionUpdate()
    {
        try {
            $data = array_merge(Request::put(), Request::get());
            $carro = Carros::findOne($data['id']);
    
            $carro->load($data);        
            $carro->marca = Marcas::findOne($carro->marca);
            $carro->update();

            $response = Response::OK;
            $dataReturn = $carro;
        } catch (Exception $e) {
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = $response;
            $dataReturn['message'] = $e->getMessage();
        } finally {
            Response::sendResponse($response, $dataReturn, ['returnFormat'=>'json']);

        }
    }

    public function actionGetOne()
    {
        $data = Request::get();
        $carro = Carros::findOne($data['id']);


        Response::sendResponse(Response::OK, $carro, ['returnFormat'=>'json']);
    }

    public function actionCreate()
    {
        try {
            $data = Request::post();
            $carro = new Carros;
            $carro->load($data);
            $carro->id = uniqid();
            $carro->marca = Marcas::findOne($carro->marca);


            $carro->save();

            $response = Response::CREATED;
            $dataReturn = $carro;
        } catch (ValidateException $e) {
            $response = Response::BAD_REQUEST;
            $dataReturn = [
                'name' => 'Bad Request',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = [
                'name' => 'Internal Server Error',
                'status' => $e->getCode(),
                'massage' => $e->getMessage(),
            ];
        } finally {
            Response::sendResponse($response, $dataReturn, ['returnFormat' => 'json']);
        }
    }

    public function actionDelete()
    {
        try {
            $data = Request::get();
            $carro = Carros::findOne($data['id']);
            $carro->delete();

            $response = Response::OK;
            $dataReturn = ['message'=>'deleted'];
        } catch (Exception $e) {
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = [
                'name' => 'Internal Server Error',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } finally {
            Response::sendResponse($response, $dataReturn, ['returnFormat'=>'json']);
        }
    }
}