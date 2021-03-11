<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function sendResponse($result, $message)
    {
        return new \Illuminate\Http\JsonResponse(self::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return new \Illuminate\Http\JsonResponse(self::makeError($error), $code);
    }

    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,//is_array($data) ? $data : $data->total() ? $data : new \stdClass(),
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
