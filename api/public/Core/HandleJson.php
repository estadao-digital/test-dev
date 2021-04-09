<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

/**
 * Class HandleJson
 * 
 * @package App\Core
 */
class HandleJson
{
    /**
     * @var int
     */
    const STATUS_OK = 200;

    /**
     * @var int
     */
    const STATUS_BAD_REQUEST = 400;

    /**
     * @var int
     */
    const STATUS_NOT_FOUND = 404;

     /**
     * @var int
     */
    const STATUS_METHOD_ALLOWED = 405;

    /**
     * @var int
     */
    const STATUS_UNPROCESSABLE_ENTITY = 422;

    /**
     * @var int
     */
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    
    /**
     * Response json object
     * 
     * @param int $code
     * @param mixed $message
     */
    public static function response($code = 200, $message = null)
    {
        header_remove();

        http_response_code($code);

        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');

        $status = [
            self::STATUS_OK => '200 OK',
            self::STATUS_BAD_REQUEST => '400 Bad Request',
            self::STATUS_NOT_FOUND => '404 Not Found',
            self::STATUS_METHOD_ALLOWED => '405 Method Not Allowed',
            self::STATUS_UNPROCESSABLE_ENTITY => '422 Unprocessable Entity',
            self::STATUS_INTERNAL_SERVER_ERROR => '500 Internal Server Error'
        ];

        $status = in_array($code, $status) ? $status[$code] : $status[self::STATUS_INTERNAL_SERVER_ERROR];

        header("Status: {$status}");

        return json_encode([
            'status' => $code < 300,
            'data' => $message
        ]);
    }
}