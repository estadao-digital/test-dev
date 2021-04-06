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
     * @var string
     */
    private $entityFile;
    
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

            $this->entityFile = "{$this->path}/{$entity}.json";

            $this->entity = json_decode(file_get_contents($this->entityFile), true);
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
     * 
     * @param int $id
     * 
     * @return array
     */
    public function findById($id = 0): array
    {
        return $this->findField($this->entity, 'id', $id);
    }

    /**
     * Create record
     * 
     * @param array $data
     * 
     * @return array
     */
    public function create($data = []): array
    {
        if ($data) {
            $lastId = $this->getLastId($this->entity);
            $data['id'] = ++$lastId;
            
            array_push($this->entity, $data);
        
            if (file_put_contents($this->entityFile, json_encode($this->entity))) {
                return [
                    'error' => false,
                    'message' => 'Successfully created',
                    'data' => $data
                ];
            }
        }
        
        return [
            'error' => true,
            'message' => 'Error creating data',
            'data' => []
        ];
    }

    /**
     * Find field in entity
     * 
     * @param array $data
     * @param string $field
     * @param int|string $value
     */
    private function findField($data = [], $field = 'id', $value = 0): array
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

    /**
     * Get last id
     * 
     * @param array
     * 
     * @return int
     */
    private function getLastId($data = []): int
    {
        if ($data) {
            return array_reduce($data, function ($a, $b) {                
                return $a > $b['id'] ? $a : $b['id'];
            });            
        }

        return 0;
    }
}