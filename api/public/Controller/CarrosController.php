<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use App\Core\Controller;
use App\Core\HandleJson;

/**
 * Class CarrosController
 * 
 * @package App\Controller
 */
class CarrosController extends Controller
{
    /**
     * Return all cars
     * 
     * @return string
     */
    public function index(): string {
        
        $car = $this->model('Carro');

        $data = $car->findAll();

        return HandleJson::response(HandleJson::STATUS_OK, $data);
    }
}