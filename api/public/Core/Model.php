<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Core;

use App\Core\Database\Database;

/**
 * Class Model
 * 
 * @package App\Core
 */
class Model
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @var string
     */
    protected $entity;

    /**
     * Model Construct
     */
    public function __construct()
	{
		$database = new Database($this->entity);
		
        $this->db = $database->conn;
	}
    
    /**
     * Find all records
     * 
     * @return array
     */
    public function findAll(): array
    {
        return $this->db->findAll();
    }

    /**
     * Find a record by id
     * 
     * @param int $id
     * 
     * @return array
     */
    public function findById($id): array
    {
        return $this->db->findById($id);
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
        return $this->db->create($data);
    }

    /**
     * Update record
     * 
     * @param array $data
     * @param int $id
     * 
     * @return array
     */
    public function update($data = [], $id): array
    {
        return $this->db->update($data, $id);
    }
}