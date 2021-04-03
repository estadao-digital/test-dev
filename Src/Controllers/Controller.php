<?php

    namespace Src\Controllers;

    Abstract class Controller
    {
        const OK            = 200;
        const CREATED       = 201;
        const ACCEPT        = 202;
        const NOCONTENT     = 204;
        const UNAUTHORIZED  = 401;
        const FORBIDDEN     = 403;
        const NOT_FOUND     = 404;
        const UNPROCESSABLE = 422;

        const ERROR         = 500;
        const UNAVAILABLE   = 503;


        static function return($data, $msg, $code)
        {
            $response = [
                'code'      => $code,
                'messages'  => $msg,
                'data'      => $data
            ];

            ob_clean();
            header("Content-type: application/json; charset=utf-8");
            
            echo json_encode($response);
            
            exit();
        }


        static function returnOk($data, string $msg = '')
        {
            self::return($data, $msg, self::OK);
        }

        static function returnCreated(mixed $data, string $msg = '')
        {
            self::return($data, $msg, self::CREATED);
        }

        static function returnNoContent(mixed $data, string $msg = '')
        {
            self::return($data, $msg, self::NOCONTENT);
        }

        static function returnNotFound(string $msg = '')
        {
            seLf::return(NULL, $msg, self::NOT_FOUND);
        }
    }

