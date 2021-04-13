<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

/**
 * Class Cors
 * 
 * @package App\Core
 */
class Cors
{
    /**
     * Resolve the cors
     * 
     * @return void
     */
    public function resolve()
    {
        $this->validateOrigin();
        $this->validateMethods();
    }

    /**
     * Validate origin
     * 
     * @return void
     */
    private function validateOrigin(): void
    {        
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
            
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }
    }

    /**
     * Validate methods
     * 
     * @return void
     */
    private function validateMethods()
    {        
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            }
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
        }
    }
}