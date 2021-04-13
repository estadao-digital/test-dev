<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

use App\Core\HandleJson;
use App\Core\Request;

/**
 * Class Controller
 * 
 * @package App\Core
 */
class Controller
{
     /**
     * @var Request
     */
    protected $request;

    /**
     * Controller construct
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->init();
    }

    /**
     * Used to start objects in the constructor without 
     * having to use the child class construct
     */
    public function init() {}

    /**
     * Instantiate the model
     * 
     * @param string $model
     * 
     * @return object
     */
    public function model($model = null): ?object
    {
        if (!is_null($model)) {
            $path = __DIR__ . '/../Model';
            $file = "{$path}/{$model}.php";
            
            if (file_exists($file)) {
                $class = "App\Model\\{$model}";            
                return new $class();
            }
        }

        return null;
    }
}