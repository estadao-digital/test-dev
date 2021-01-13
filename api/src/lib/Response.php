<?php

namespace app\lib;

abstract class Response {

    const NOT_FOUND = [
        'status' => 404,
        'name' => 'Not Found',
        'code' => 0,
    ];

    const OK = [
        'name' => 'OK',
        'message' => 'OK',
        'code' => 0,
        'status' => 200
    ];

    const UNAUTHORIZED = [
                'name' => 'Unauthorized',
                'message' => 'Unauthorized',
                'code' => 0,
                'status' => 401,
    ];

    const CREATED = [
        'name' => 'Created',
        'message' => 'Created',
        'status' => 201,
    ];

    const BAD_REQUEST = [
        'name' => 'Bad Request',
        'message' => 'Bad Request',
        'status' => 400,
    ];

    const INTERNAL_SERVER_ERROR = [
        'name' => 'Internal Server Error',
        'message' => 'Internal Server Error',
        'status' => 500,
    ];

    /**
     * @param array $response - response header data
     */
    public static function sendResponse(array $response, $returnData, array $config = ['returnFormat' => 'text']){
        header("{$_SERVER['SERVER_PROTOCOL']} {$response['status']} {$response['name']}");

        switch ($config['returnFormat']) {
            case 'json':
                echo json_encode($returnData);
                break;
        }

        if ($config['stopService'] ?? true) die;
    }

}