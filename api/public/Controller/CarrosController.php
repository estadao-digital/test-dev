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
 * Class CarrosController
 * 
 * @package App\Controller
 */
class CarrosController extends Controller
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
        $this->model = $this->model('Carro');
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

    /**
     * Return the car by id
     * 
     * @return string
     */
    public function view(): string 
    {        
        return HandleJson::response(
            HandleJson::STATUS_OK, 
            $this->model->findById($this->request->getParam())
        );
    }

    /**
     * Create car
     * 
     * @return string
     */
    public function create(): string 
    {
        $created = $this->model->create($this->request->getBody());
        
        if (!$created['error']) {
            return HandleJson::response(
                HandleJson::STATUS_OK, 
                $created
            );
        }

        return HandleJson::response(
            HandleJson::STATUS_NOT_FOUND, 
            $created['message']
        );
    }

    /**
     * Update car
     * 
     * @return string
     */
    public function update(): string 
    {
        $updated = $this->model->update(
            $this->request->getBody(), 
            $this->request->getParam()
        );
        
        if (!$updated['error']) {
            return HandleJson::response(
                HandleJson::STATUS_OK, 
                $updated
            );
        }

        return HandleJson::response(
            HandleJson::STATUS_NOT_FOUND, 
            $updated['message']
        );
    }
}