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
     * Returns if the controller is not found
     * 
     * @return void 
     */
    public function controllerNotFound(): void
    {
        echo HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Controller Not Found!');
    }

    /**
     * Returns if the method is not found
     * 
     * @return void
     */
    public function methodNotFound(): void
    {        
        echo HandleJson::response(600, 'Method Not Found!');
    }

    /**
     * Returns true if request method is post
     * 
     * @return bool
     */
    public function isPost(): bool
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            return true;
        }

        return false;
    }

    /**
     * Returns true if request method is put
     * 
     * @return bool
     */
    public function isPut(): bool
    {        
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            return (isset($_POST['_METHOD']) == 'PUT') ? true : false;
        }

        return false;
    }

    /**
     * Returns true if request method is delete
     * 
     * @return bool
     */
    public function isDelete(): bool
    {        
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            return (isset($_POST['_METHOD']) == 'DELETE') ? true : false;
        }

        return false;
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