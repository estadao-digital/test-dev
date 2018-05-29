<?php
/**
 * View Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\View;
/**
 * View Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class View
{
    /**
     * Provide a json response
     * 
     * @param Array $array Fields for json conversion
     * 
     * @return print(json_encode())
     */
    public static function json($array = array())
    {
        if (ob_get_length()) {
            ob_clean();
        }
        ob_start();
        header('Content-Type: application/json');
        return print(json_encode($array));
    }
}
