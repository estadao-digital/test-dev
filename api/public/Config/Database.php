<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Config;

/**
 * Class Database
 * 
 * @package App\Config
 */
class Database
{
    /**
     * @var array
     */
    private $json = [
        'datasource' => 'DatabaseJson',
        'path' => 'estadao'
    ];

    /**
     * @var array
     */
    private $mysql = [
        'datasource' =>'DatabaseMysql',
        'host' => '',
        'username' => '',
        'password' => '',
        'dbname' => ''
    ];

    public function __construct()
    {
        return $this->default = $this->json;
    }
}