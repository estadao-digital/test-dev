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
use App\Model\CarroModel;
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
        $carro = new CarroModel();
        $param = json_decode(key($this->parametersRequest));
        if (trim($param->term) != "") {
            $carros = $carro->select()->where('modelo', 'like','%'.$param->term.'%')->get();
            return View::json(array("carros" => $carros->carroCollection->results));
        }
        $carros = $carro->select()->get();
        return View::json(array("carros" => $carros->carroCollection->results));
    }
    /**
     * Save a car in database
     *
     * @return View::json
     */
    public function salvarCarro($id = 0)
    {
        $postData = json_decode(key($this->parametersRequest));
        $carro = new CarroModel();
        $carro->fields['id_marca'] = (int)$postData->id_marca;
        $carro->fields['modelo'] = substr($postData->modelo, 0, 30);
        if($id > 0) {
            $carro->id = $id;
        }
        $carro->save();
        return View::json(array("error"=>false, "message" => "Registro gravado"));
    }
    /**
     * Show a car
     *
     * @return View::json
     */
    public function verCarro($id)
    {
        $carro = new CarroModel();
        $register = $carro->findById($id);
        return View::json(array("carro" => $register));
    }
    /**
     * Delete a car
     *
     * @return View::json
     */
    public function excluirCarro($id)
    {
        $carro = new CarroModel();
        $carro->delete($id);
        return View::json(array("msg"=>"Excluir o carro $id"));
    }
    /**
     * Delete a car
     *
     * @return View::json
     */
    public function marcasCarro($id)
    {
        $marca = array(); 
        $marca[] = array("id" => 1, "marca" => "Chevrolet");
        $marca[] = array("id" => 2, "marca" => "Fiat");
        $marca[] = array("id" => 3, "marca" => "Ford");
        return View::json(array("marcas" => $marca));
    }
}
