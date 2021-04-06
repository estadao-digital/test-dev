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
     */
    public function findById($id = null): array
    {
        return $this->db->findById($id);
    }
}