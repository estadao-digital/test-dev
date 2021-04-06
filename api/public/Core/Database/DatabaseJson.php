<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core\Database;

use App\Core\HandleJson;
use App\Config\Database;

/**
 * Class DatabaseJson
 * 
 * @package App\Core\Database
 */
class DatabaseJson implements DatabaseInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $entity;
    
    /**
     * DatabaseJson construct
     * 
     * @param Database $config
     * @param string $entity
     */
    public function __construct(Database $config, $entity = '')
    {
        if ($config->default['path'] && $entity) {
            $this->path = __DIR__ . "/../../database/{$config->default['path']}";

            if (!file_exists($this->path)) {
                echo HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Database Path Not Found!');
                exit;
            }

            $this->entity = json_decode(file_get_contents($this->path . "/{$entity}.json"), true);
        } else {
            echo HandleJson::response(HandleJson::STATUS_NOT_FOUND, 'Database Path or Entity is Empty!');
            exit;
        }
    }

    /**
     * Find all records
     * 
     * @return array
     */
    public function findAll(): array
    {        
        return $this->entity;
    }

    /**
     * Find a record by id
     */
    public function findById($id = null): array
    {
        return $this->findField($this->entity, 'id', $id);
    }

    /**
     * Find field in entity
     * 
     * @param array $data
     * @param string $field
     * @param int|string $value
     */
    private function findField($data, $field = 'id', $value = 0): array
    {
        if ($data) {
            return array_filter(
                $data,
                function ($e) use ($field, $value) {
                    return $e[$field] == $value;
                }
            );
        }

        return [];
    }
}