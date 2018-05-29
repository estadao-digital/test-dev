<?php
/**
 * Controller BaseController.
 *
 * PHP version 5.6
 *
 * @category Controller
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace App\Controller;

use FastApi\View\View;
use FastApi\RequestValidator\RequestValidator;
/**
 * Controller BaseController.
 *
 * PHP version 5.6
 *
 * @category Controller
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class BaseController
{
    public $parametersRequest = array();
    /**
     * Provide index
     *
     * @return View::json
     */
    public function index($a)
    {
        return View::json(array("msg"=>"Fast Api! It's Alive :)"));
    }
}
