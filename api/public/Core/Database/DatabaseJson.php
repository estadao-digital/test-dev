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
        return $this->find('id', $id);
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
        
            if ($this->save()) {
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
     * Update record
     * 
     * @param array $data
     * @param int $id
     * 
     * @return array
     */
    public function update($data = [], $id = 0): array
    {
        if ($data && $id) {
            $find = $this->find('id', $id);

            if ($find) {
                $data['id'] = $id;
                $this->entity[key($find)] = $data;

                if ($this->save()) {
                    return [
                        'error' => false,
                        'message' => 'Successfully updated',
                        'data' => $data
                    ];
                }
            }
        }
        
        return [
            'error' => true,
            'message' => 'Error updating data',
            'data' => []
        ];
    }

    /**
     * Delete record
     * 
     * @param int $id
     * 
     * @return array
     */
    public function delete($id = 0): array
    {
        $find = $this->find('id', $id);

        if ($find) {
            unset($this->entity[key($find)]);

            if ($this->save()) {
                return [
                    'error' => false,
                    'message' => 'Successfully delete',
                    'data' => []
                ];
            }
        }
        
        return [
            'error' => true,
            'message' => 'Error deleting data',
            'data' => []
        ];
    }

    /**
     * Find entity
     *      
     * @param string $field
     * @param int|string $value
     * 
     * @return array
     */
    private function find($field = 'id', $value = 0): array
    {
        if ($this->entity) {
            return array_filter(
                $this->entity,
                function ($e) use ($field, $value) {
                    if (isset($e[$field])) {
                        return $e[$field] == $value;
                    }
                }
            );
        }

        return [];
    }

    /**
     * Get last id
     * 
     * @return int
     */
    private function getLastId(): int
    {
        if ($this->entity) {
            return array_reduce($this->entity, function ($a, $b) {                
                return $a > $b['id'] ? $a : $b['id'];
            });            
        }

        return 0;
    }

    /**
     * Save data
     * 
     * @return bool
     */
    private function save(): bool
    {
        return file_put_contents($this->entityFile, json_encode($this->entity));
    }
}