<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

use App\Core\Router;
use App\Core\Request;
use App\Core\Cors;

/**
 * Class App
 * 
 * @package App\Core
 */
class App
{
    /**
     * App construct
     * 
     */
    public function __construct()
    {
        // Initializes cors
        $cors = new Cors();
        $cors->resolve();

        // Initializes the routes
        $router = new Router(new Request);
        $router->resolve();
    }
}