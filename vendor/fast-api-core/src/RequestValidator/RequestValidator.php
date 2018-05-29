<?php
/**
 * RequestValidator Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\RequestValidator;
/**
 * RequestValidator Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class RequestValidator
{
    private static $_validator = [];
    /**
     * Build the validator
     * 
     * @param String $field Field to validate
     * 
     * @return boolean true
     */
    public static function make($field = '')
    {
        if (trim($field) == "") {
            return false;
        }
        $field     = explode("|", $field);

        foreach ($field as $data) {
            self::$_validator[] = $data;
        }
        return true;
    }
    /**
     * Run the validator
     * 
     * @param Array $fields Fields in the validator
     * 
     * @return boolean true
     */
    public static function validate($fields)
    {
        foreach (self::$_validator as $field => $value) {
            if (!isset($fields[$value]) || $fields[$value] == '') {
                return false;
            }
        }
        return true;
    }
}
