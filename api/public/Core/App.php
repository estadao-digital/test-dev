<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

/**
 * Class App
 * 
 * @package App\Core
 */
class App
{
    public function __construct(Router $router)
    {   
        $router->resolve();
    }
}