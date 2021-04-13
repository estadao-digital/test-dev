<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use App\Core\Controller;
use App\Core\HandleJson;
use App\Core\Request;

/**
 * Class BrandsController
 * 
 * @package App\Controller
 */
class BrandsController extends Controller
{
    /**
     * @var object
     */
    private $model;

    /**
     * Used to start objects in the constructor
     */
    public function init()
    {
        $this->model = $this->model('Brand');
    }

    /**
     * Return all cars
     * 
     * @return string
     */
    public function index(): string 
    {
        return HandleJson::response(
            HandleJson::STATUS_OK, 
            $this->model->findAll()
        );
    }
}