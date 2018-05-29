<?php
/**
 * Controller CarrosController.
 *
 * PHP version >= 5.6
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
 * Controller CarrosController.
 *
 * PHP version >= 5.6
 *
 * @category Controller
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class CarrosController
{
    public $parametersRequest = array();
    /**
     * Provide the cars list
     *
     * @return View::json
     */
    public function listaCarros()
    {
        return View::json(array("msg"=>"Lista de carros"));
    }
    /**
     * Save a car in database
     *
     * @return View::json
     */
    public function salvarCarro($id = 0)
    {
        return View::json(array("msg"=>"Salva o carro $id"));
    }
    /**
     * Show a car
     *
     * @return View::json
     */
    public function verCarro($id)
    {
        return View::json(array("msg"=>"Ver o carro $id"));
    }
    /**
     * Delete a car
     *
     * @return View::json
     */
    public function excluirCarro($id)
    {
        return View::json(array("msg"=>"Excluir o carro $id"));
    }
    
}
