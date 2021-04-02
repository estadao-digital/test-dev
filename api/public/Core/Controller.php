<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

use App\Core\HandleJson;

/**
 * Class Controller
 * 
 * @package App\Core
 */
class Controller
{
    /**
     * Instantiate the model
     * 
     * @param string $model
     * 
     * @return object
     */
    public function model($model = null): object
    {
        if (!is_null($model)) {                    
            $class = "App\Model\\{$model}";
            
            return new $class();
        }
    }

    /**
     * Return params
     * 
     * @return string
     */
    public function params(): string
    {
        $request = explode('/', $_SERVER['REQUEST_URI']);

        return (isset($request[3])) ? $request[3] : null;
    }

    /**
     * Return id of params
     * 
     * @return string
     */
    public function getParamsId(): string
    {
        $params = $this->params();

        if (!is_null($params)) {
            return explode('?', $params)[0];            
        }
    }
}