<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core\Database;

use App\Core\Database\DatabaseInterface;
use App\Core\HandleJson;

/**
 * Class Database
 * 
 * @package App\Core\Database
 */
class Database
{
    /**
     * @var object
     */
    public $conn;

    /**
     * Database construct
     * 
     * @param string $entity
     */
    public function __construct($entity)
    {
        $config = new \App\Config\Database;

        if ($config->default['datasource']) {
            $file = __DIR__ . "/{$config->default['datasource']}.php";

            if (!file_exists($file)) {
                echo HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Database Not Found!');
                exit;
            }

            $class = "App\Core\Database\\{$config->default['datasource']}";

            $this->conn = new $class($config, $entity);
        } else {
            echo HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Datasource Empty!');
            exit;
        }
    }
}